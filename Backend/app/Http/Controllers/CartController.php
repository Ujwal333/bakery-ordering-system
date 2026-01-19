<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // Get cart items
    public function index(Request $request)
    {
        $cart = Cart::getOrCreateCart();
        $cart->load('items.product');

        // Force recalculate totals to ensure accuracy
        $subtotal = 0;
        $itemCount = 0;
        foreach ($cart->items as $item) {
            // Ensure total_price is correct
            if ($item->total_price != $item->unit_price * $item->quantity) {
                $item->total_price = $item->unit_price * $item->quantity;
                $item->save();
            }
            $subtotal += $item->total_price;
            $itemCount += $item->quantity;
        }

        return response()->json([
            'cart' => $cart,
            'subtotal' => $subtotal,
            'item_count' => $itemCount,
        ]);
    }

    // Add item to cart
    public function addItem(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'item_name' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'customizations' => 'nullable|array',
        ]);

        return $this->performAddItem(
            $request->product_id,
            $request->item_name,
            $request->unit_price,
            $request->quantity,
            $request->customizations
        );
    }

    /**
     * Centralized logic for adding items to the cart.
     */
    private function performAddItem($productId, $itemName, $unitPrice, $quantity, $customizations = null)
    {
        DB::beginTransaction();

        try {
            $cart = Cart::getOrCreateCart();

            // If product_id is provided, try to get details from DB to ensure accuracy
            if ($productId) {
                $product = Product::find($productId);
                if ($product) {
                    $itemName = $product->name;
                    $unitPrice = $product->price;
                    
                    // ✅ STOCK VALIDATION
                    // Check if product has enough stock
                    if ($product->stock < $quantity) {
                        DB::rollback();
                        return response()->json([
                            'success' => false,
                            'message' => "Only {$product->stock} units of '{$product->name}' are currently available. Please contact us for larger orders.",
                            'available_stock' => $product->stock,
                            'requested_quantity' => $quantity
                        ], 400);
                    }
                    
                    // Check if adding to existing cart item would exceed stock
                    $existingCartItem = $cart->items()
                        ->where('product_id', $productId)
                        ->where('item_name', $itemName)
                        ->first();
                    
                    if ($existingCartItem) {
                        $totalQuantity = $existingCartItem->quantity + $quantity;
                        if ($totalQuantity > $product->stock) {
                            DB::rollback();
                            $availableToAdd = $product->stock - $existingCartItem->quantity;
                            return response()->json([
                                'success' => false,
                                'message' => "You already have {$existingCartItem->quantity} units in cart. Only {$availableToAdd} more units available. Total stock: {$product->stock}.",
                                'available_stock' => $product->stock,
                                'in_cart' => $existingCartItem->quantity,
                                'can_add' => max(0, $availableToAdd)
                            ], 400);
                        }
                    }
                } else {
                    DB::rollback();
                    return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
                }
            }

            // Check if similar item exists in cart
            $query = $cart->items()
                ->where('product_id', $productId)
                ->where('item_name', $itemName);

            if ($customizations) {
                $query->where('customizations', json_encode($customizations));
            } else {
                $query->whereNull('customizations');
            }

            $existingItem = $query->first();

            if ($existingItem) {
                $existingItem->quantity += $quantity;
                $existingItem->total_price = $existingItem->quantity * $existingItem->unit_price;
                $existingItem->save();
            } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $productId,
                    'item_name' => $itemName,
                    'customizations' => $customizations,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $quantity * $unitPrice,
                ]);
            }

            DB::commit();
            $cart->load('items.product');

            // Recalculate totals
            $subtotal = $cart->items->sum('total_price');
            $itemCount = $cart->items->sum('quantity');

            return response()->json([
                'success' => true,
                'message' => 'Item added to cart',
                'cart' => $cart,
                'subtotal' => $subtotal,
                'item_count' => $itemCount,
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Failed to add item: ' . $e->getMessage()], 500);
        }
    }

    // Update cart item quantity
    public function updateItem(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::getOrCreateCart();
        $cartItem = CartItem::where('cart_id', $cart->id)->findOrFail($itemId);

        // ✅ STOCK VALIDATION for regular products
        if ($cartItem->product_id) {
            $product = Product::find($cartItem->product_id);
            if ($product && $request->quantity > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => "Only {$product->stock} units of '{$product->name}' are available. Please contact us for larger orders.",
                    'available_stock' => $product->stock,
                    'requested_quantity' => $request->quantity
                ], 400);
            }
        }

        $cartItem->updateQuantity($request->quantity);

        $cart->load('items.product');

        // Recalculate totals
        $subtotal = $cart->items->sum('total_price');
        $itemCount = $cart->items->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Cart updated',
            'cart' => $cart,
            'subtotal' => $subtotal,
            'item_count' => $itemCount,
        ]);
    }

    // Remove item from cart
    public function removeItem(Request $request, $itemId)
    {
        $cart = Cart::getOrCreateCart();
        $cartItem = CartItem::where('cart_id', $cart->id)->findOrFail($itemId);

        $cartItem->delete();

        $cart->load('items.product');

        // Recalculate totals
        $subtotal = $cart->items->sum('total_price');
        $itemCount = $cart->items->sum('quantity');

        return response()->json([
            'message' => 'Item removed from cart',
            'cart' => $cart,
            'subtotal' => $subtotal,
            'item_count' => $itemCount,
        ]);
    }

    // Clear cart
    public function clearCart(Request $request)
    {
        $cart = Cart::getOrCreateCart();
        $cart->clear();

        return response()->json([
            'message' => 'Cart cleared',
            'cart' => $cart,
            'subtotal' => 0,
            'item_count' => 0,
        ]);
    }

    // Add custom cake to cart
    public function addCustomCake(Request $request)
    {
        $request->validate([
            'size' => 'required|string',
            'size_price' => 'required|numeric|min:0',
            'flavor' => 'required|string',
            'flavor_price' => 'required|numeric|min:0',
            'frosting' => 'required|string',
            'frosting_price' => 'required|numeric|min:0',
            'decorations' => 'nullable', // Can be array or string if FormData
            'custom_message' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'cake_type' => 'nullable|string',
            'image' => 'nullable|image|max:2048' // Max 2MB
        ]);

        // Calculate total price
        $basePrice = $request->size_price + $request->flavor_price + $request->frosting_price;

        // Parse decorations if it came as string from FormData
        $decorationsRaw = $request->decorations;
        if (is_string($decorationsRaw)) {
             $decorations = json_decode($decorationsRaw, true);
        } else {
             $decorations = $decorationsRaw;
        }

        // Add decorations price
        $decorationsPrice = 0;
        if ($decorations && is_array($decorations)) {
            foreach ($decorations as $decoration) {
                $decorationsPrice += $decoration['price'] ?? 0;
            }
        }

        $unitPrice = $basePrice + $decorationsPrice;
        $totalPrice = $unitPrice * $request->quantity;

        // Handle Image Upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('custom-cake-images', 'public');
            $imagePath = '/storage/' . $path;
        }

        // Create customizations array
        $customizations = [
            'cake_type' => $request->cake_type ?? 'Standard',
            'size' => $request->size,
            'size_price' => $request->size_price,
            'flavor' => $request->flavor,
            'flavor_price' => $request->flavor_price,
            'frosting' => $request->frosting,
            'frosting_price' => $request->frosting_price,
            'decorations' => $decorations,
            'custom_message' => $request->custom_message,
            'reference_image' => $imagePath
        ];

        return $this->performAddItem(
            null,
            "Custom Cake - {$request->size} {$request->flavor}",
            $unitPrice,
            $request->quantity,
            $customizations
        );
    }

    // Get cart item count
    public function getCount(Request $request)
    {
        $cart = Cart::getOrCreateCart();

        return response()->json([
            'item_count' => $cart->total_items,
        ]);
    }
}
