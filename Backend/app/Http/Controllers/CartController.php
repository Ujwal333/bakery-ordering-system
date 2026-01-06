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

        return response()->json([
            'cart' => $cart,
            'subtotal' => $cart->subtotal,
            'total_items' => $cart->total_items,
        ]);
    }

    // Add item to cart
    public function addItem(Request $request)
    {
        $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'item_name' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'customizations' => 'nullable|array',
        ]);

        DB::beginTransaction();

        try {
            $cart = Cart::getOrCreateCart();

            // Check if similar item exists in cart
            $existingItem = $cart->items()
                ->where('item_name', $request->item_name)
                ->where('customizations', json_encode($request->customizations))
                ->first();

            if ($existingItem) {
                // Update quantity if item already exists
                $existingItem->quantity += $request->quantity;
                $existingItem->total_price = $existingItem->quantity * $existingItem->unit_price;
                $existingItem->save();
            } else {
                // Create new cart item
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $request->product_id,
                    'item_name' => $request->item_name,
                    'customizations' => $request->customizations,
                    'quantity' => $request->quantity,
                    'unit_price' => $request->unit_price,
                    'total_price' => $request->quantity * $request->unit_price,
                ]);
            }

            DB::commit();

            // Reload cart
            $cart->load('items.product');

            return response()->json([
                'message' => 'Item added to cart',
                'cart' => $cart,
                'subtotal' => $cart->subtotal,
                'total_items' => $cart->total_items,
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to add item: ' . $e->getMessage()], 500);
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

        $cartItem->updateQuantity($request->quantity);

        $cart->load('items.product');

        return response()->json([
            'message' => 'Cart updated',
            'cart' => $cart,
            'total' => $cart->total,
            'item_count' => $cart->item_count,
        ]);
    }

    // Remove item from cart
    public function removeItem(Request $request, $itemId)
    {
        $cart = Cart::getOrCreateCart();
        $cartItem = CartItem::where('cart_id', $cart->id)->findOrFail($itemId);

        $cartItem->delete();

        $cart->load('items.product');

        return response()->json([
            'message' => 'Item removed from cart',
            'cart' => $cart,
            'subtotal' => $cart->subtotal,
            'total_items' => $cart->total_items,
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
            'total_items' => 0,
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
            'decorations' => 'nullable|array',
            'custom_message' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
        ]);

        // Calculate total price
        $basePrice = $request->size_price + $request->flavor_price + $request->frosting_price;

        // Add decorations price
        $decorationsPrice = 0;
        if ($request->decorations && is_array($request->decorations)) {
            foreach ($request->decorations as $decoration) {
                $decorationsPrice += $decoration['price'] ?? 0;
            }
        }

        $unitPrice = $basePrice + $decorationsPrice;
        $totalPrice = $unitPrice * $request->quantity;

        // Create customizations array
        $customizations = [
            'size' => $request->size,
            'size_price' => $request->size_price,
            'flavor' => $request->flavor,
            'flavor_price' => $request->flavor_price,
            'frosting' => $request->frosting,
            'frosting_price' => $request->frosting_price,
            'decorations' => $request->decorations,
            'custom_message' => $request->custom_message,
        ];

        // Add to cart
        return $this->addItem(new Request([
            'product_id' => null, // Custom cakes don't have a product ID
            'item_name' => "Custom Cake - {$request->size} {$request->flavor} with {$request->frosting}",
            'quantity' => $request->quantity,
            'unit_price' => $unitPrice,
            'customizations' => $customizations,
        ]));
    }

    // Get cart item count
    public function getCount(Request $request)
    {
        $cart = Cart::getOrCreateCart();

        return response()->json([
            'count' => $cart->total_items,
        ]);
    }
}
