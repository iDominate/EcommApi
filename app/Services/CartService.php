<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class CartService  
{
    /**
     * Create A Cart
     * 
     * @param int $user_id
     * @param int $number_of_products
     * @param int $number_of_items
     * @param int $total_price
     * @return App\Models\Cart
     */
    public static function create(int $user_id, int $number_of_products = 0, int $number_of_items = 0, int $total_price = 0) : Cart
    {
        $cart = Cart::create([
            'user_id' => $user_id,
            'number_of_products' => $number_of_products,
            'number_of_items' => $number_of_items,
            'total_price' => $total_price
        ]);

        return $cart;
    }

    /**
     * Clears The Cart
     * @param int user_id
     * @return void
     */
    public static function clearCart(int $cart_id) : void {
        $cartProducts = CartProduct::where('cart_id',$cart_id)->get();
        
        $cartProducts->each(function($cartProduct){
            $cartProduct->delete();
        });
    }

    public static function saveCartProduct(int $cart_id, Request $request) : CartProduct {
        $product_unit_price = Product::where('name', $request->name)->first()->unit_price;
        $cartProduct = CartProduct::create([
            'cart_id' => $cart_id,
            'name' => $request->name,
            'product_unit_count' => $request->product_unit_count,
            'unit_price' => $product_unit_price,
            'total_price' => $request->product_unit_count * $request->unit_price
        ]);

        return $cartProduct;
    }

    public static function updateCartProduct(CartProduct $cartProduct, Request $request): CartProduct {
        $cartProduct->update([
            'product_unit_count' => $request->product_unit_count,
            'total_price' => $request->product_unit_count * $cartProduct->unit_price
        ]);

        return $cartProduct;
    }
}
