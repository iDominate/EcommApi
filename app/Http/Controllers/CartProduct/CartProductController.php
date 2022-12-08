<?php

namespace App\Http\Controllers\CartProduct;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartProduct\CreateCartProductRequest;
use App\Http\Requests\CartProduct\UpdateCartProductRequest;
use App\Http\Resources\CartProduct\CartProductCollectionResource;
use App\Http\Resources\CartProduct\CartProductResource;
use App\Models\CartProduct;
use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CartProductController extends Controller
{
    /**
     * Display All Products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cart = $request->user()->cart;
        return response()->returnResult(data: new CartProductCollectionResource(CartProduct::paginate(5)));
    }

    /**
     * Store A New Product.
     *
     * @param  \App\Http\Requests\CartProduct\CreateCartProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCartProductRequest $request)
    {
        $existingProduct = CartProduct::where('name', $request->validated()['name'])->first();
        if($existingProduct) response()->returnResult(content: 'Already Exists', response_code: Response::HTTP_UNPROCESSABLE_ENTITY);
        
        $cartProduct = CartService::saveCartProduct($request->user()->cart->id, $request);
        
        return response()->returnResult(data: new CartProductResource($cartProduct), response_code: Response::HTTP_CREATED);
    }

    /**
     * Display A Certain Product.
     *
     * @param  \App\Models\CartProduct $cartProduct
     * @return \Illuminate\Http\Response
     */
    public function show(CartProduct $cartProduct)
    {
        return response()->returnResult(data: new CartProductResource($cartProduct));
    }

    /**
     * Update A Certain Product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CartProduct  $cartProduct
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCartProductRequest $request,CartProduct $cartProduct)
    {
        CartService::updateCartProduct($cartProduct, $request);
        return response()->returnResult(data: new CartProductResource($cartProduct));
    }

    /**
     * Remove A Product.
     *
     * @param  \App\Models\CartProduct $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartProduct $cartProduct)
    {
        $cartProduct->delete();
        return response()->returnResult();
    }
}
