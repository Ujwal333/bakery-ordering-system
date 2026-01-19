<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Cart extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'session_id', 'total_price'];
    protected $appends = ['subtotal', 'total_items'];
        
        public function user() {
            return $this->belongsTo(User::class);
        }
        
        public function items() {
            return $this->hasMany(CartItem::class);
        }

        /**
         * Merge guest cart using old session ID into authenticated user's cart
         */
        public static function mergeGuestCart($oldSessionId)
        {
            $userId = auth()->id();
            if (!$userId || !$oldSessionId) return;

            $guestCart = self::where('session_id', $oldSessionId)
                             ->whereNull('user_id')
                             ->first();
            
            if (!$guestCart) return;

            $userCart = self::firstOrCreate(['user_id' => $userId]);

            if ($guestCart->id !== $userCart->id) {
                foreach ($guestCart->items as $item) {
                    $item->update(['cart_id' => $userCart->id]);
                }
                $guestCart->delete();
            }
        }

        /**
         * Get or create cart for current user/session
         */
        public static function getOrCreateCart()
        {
            $userId = auth()->id();
            $sessionId = session()->getId();

            if ($userId) {
                // Check if there's a guest cart for this session that needs merging
                $guestCart = self::where('session_id', $sessionId)
                                 ->whereNull('user_id')
                                 ->first();
                
                $userCart = self::firstOrCreate(['user_id' => $userId]);

                if ($guestCart && $guestCart->id !== $userCart->id) {
                    // Simple merge: move all items to user cart
                    // Items with same details can be merged later or kept separate
                    foreach ($guestCart->items as $item) {
                        $item->update(['cart_id' => $userCart->id]);
                    }
                    $guestCart->delete();
                }
                
                $userCart->load('items');
                return $userCart;
            } else {
                $guestCart = self::firstOrCreate(['session_id' => $sessionId]);
                $guestCart->load('items'); 
                return $guestCart;
            }
        }

        /**
         * Get cart subtotal
         */
        public function getSubtotalAttribute()
        {
            return (float) $this->items->sum('total_price');
        }

        /**
         * Get total items count
         */
        public function getTotalItemsAttribute()
        {
            return (int) $this->items->sum('quantity');
        }

        /**
         * Clear all items from cart
         */
        public function clear()
        {
            $this->items()->delete();
            return $this;
        }
}
