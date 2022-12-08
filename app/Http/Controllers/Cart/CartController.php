<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Services\CartService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    /**
     * Display The Cart.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $cart = Cart::with('cart_products')->where('user_id', $request->user()->id)->get();
        return response()->returnResult(data: $cart);
    }

    /**
     * Clears the Cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function clear(Request $request)
    {
        CartService::clearCart($request->user()->cart->id);
        return response(status: Response::HTTP_NO_CONTENT);
    }
}
