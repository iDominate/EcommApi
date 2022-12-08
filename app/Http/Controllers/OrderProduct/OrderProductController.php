<?php

namespace App\Http\Controllers\OrderProduct;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderProduct\AddOrderProductRequest;
use App\Http\Requests\OrderProduct\UpdateOrderProductRequest;
use App\Http\Resources\OrderProduct\OrderProductCollectionResource;
use App\Http\Resources\OrderProduct\OrderProductResource;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Services\OrderService;
use Symfony\Component\HttpFoundation\Response;

class OrderProductController extends Controller
{
    /**
     * Display A Listing Of Order Products For A Specific Order.
     *
     * @return \Illuminate\Http\Response
     */
    public function showOrderProducts(Order $order)
    {
        return response()->returnResult(data: new OrderProductCollectionResource(OrderProduct::where('order_id', $order->id)->get()));
    }

    /**
     * Store A Newly Created Order Producte.
     *
     * @param  \App\Http\Resources\OrderProduct\OrderProductResource  $request
     * @return \Illuminate\Http\Response
     */
    public function addToCart(AddOrderProductRequest $request)
    {
        $orderProduct = OrderProduct::create($request->validated());
        $product = Product::where('name', $request->name)->first();
        Product::decreaseProduct($orderProduct, $product);
        return response()->returnResult(data: new OrderProductResource($orderProduct), response_code: Response::HTTP_CREATED);
    }

    /**
     * Display An Order Product.
     *
     * @param  \App\Models\OrderProduct  $orderProduct
     * @return \App\Http\Requests\OrderProduct\UpdateOrderProductRequest
     */
    public function EditProduct(OrderProduct $orderProduct, UpdateOrderProductRequest $request)
    {
        OrderService::updateOrder($orderProduct, $request->validated()['product_unit_count']);
        return response()->returnResult(data: new OrderProductResource($orderProduct));
    }

    /**
     * Remove A Product From Order
     *
     * @param  \App\Models\OrderProduct $id
     * @return \Illuminate\Http\Response
     */
    public function removeProduct(OrderProduct $orderProduct)
    {
        $orderProduct->delete();
        return response()->returnResult(response_code: Response::HTTP_NO_CONTENT);
    }
}
