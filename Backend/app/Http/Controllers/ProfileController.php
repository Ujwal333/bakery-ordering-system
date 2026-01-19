<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavedItem;
use App\Models\Order;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getSettings()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        return response()->json([
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'initial' => strtoupper(substr($user->name, 0, 1)),
                'profile_image' => $user->profile_image
            ],
            'stats' => [
                'saved_count' => $user->savedItems()->count(),
                'orders_count' => $user->orders()->count(),
            ],
            'saved_items' => $user->savedItems()->with('product')->latest()->take(5)->get(),
            'recent_orders' => $user->orders()->latest()->take(3)->get(),
            'addresses' => $user->addresses()->get()
        ]);
    }

    public function toggleSaved(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        $user = Auth::user();
        
        $exists = SavedItem::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($exists) {
            $exists->delete();
            return response()->json(['status' => 'removed', 'message' => 'Removed from wishlist']);
        }

        SavedItem::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id
        ]);

        return response()->json(['status' => 'added', 'message' => 'Added to wishlist']);
    }
}
