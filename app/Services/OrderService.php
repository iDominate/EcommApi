<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\CartProduct;
use App\Models\OrderProduct;

class OrderService {

    /**
     * Update An Order Producy
     * 
     * @param \App\Models\OrderProduct $old
     * @param int $quantity
     * @return void
     */
    public static function updateOrder(OrderProduct $old, int $quantity): void {
        $new_price = $quantity * $old->unit_price;
        $old->product_unit_count = $quantity;
        $old->total_price = $new_price;
        $old->save();
    }

    /**
     * Create An Order
     * 
     * @param \App\Models\User
     * @param \App\Models\Cart
     * @return \App\Models\Order
     */
    private static function createOrder(User $user, Cart $cart) : Order {
        $order = new Order();
        $order->name_of_owner = $user->name;
        $order->email_of_owner = $user->email;
        $order->user_id = $user->id;
        $order->number_of_products = $cart->number_of_products;
        $order->number_of_items = $cart->number_of_items;
        $order->total_price = $cart->total_price;
        $order->status = OrderStatus::Paid;
        $order->save();
        return $order;
    }

    /**
     * Turn A Cart Product to An Order Product
     * 
     * @param \App\Models\Cart
     * @param int $order_id
     * @return void
     */
    private static function fromCartProductsToOrderProducts(Cart $cart, int $order_id): void {
        $cart->cart_products->each(function($product) use ($order_id){
            CartProduct::toOrderProduct($product, $order_id);
        });
    }

    /**
     * Checkout
     * 
     * @param \App\Models\User
     * @param \App\Models\Cart
     * @return \App\Models\Order
     */
    public static function checkout(User $user, Cart $cart) : Order {
        $order = self::createOrder($user, $cart);
        self::fromCartProductsToOrderProducts($cart, $order->id);
        return $order;
    }
}