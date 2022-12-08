<?php

namespace App\Http\Controllers\Order;

use App\Models\User;
use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class OrderControllers extends Controller
{
    /**
     * Changes Order Status
     *  @param \App\Models\Order $order
     *  @param int $status
     *  @return \Illuminate\Http\Response
     */
    public function changeStatus(Order $order, int $status){
        if($order->status < $status)
        {
            $order->status = $status;
            return response()->returnResult();
        }
        return response()->returnResult(response_code: Response::HTTP_FORBIDDEN);
    }

    /**
     * Delete Order
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function deleteOrder(Order $order){
        $order->delete();
        return response()->returnResult(response_code: Response::HTTP_NO_CONTENT);
    }

    public function createOrder(Request $request){
        $cart = $request->user()->cart;
        $user = User::where('id', $request->user()->id)->first();
        $order = OrderService::checkout($user, $cart);
        return response()->returnResult(data: $order);

    }

}
