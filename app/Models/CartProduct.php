<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;

class CartProduct extends Model
{
    use HasFactory;

    //'cart_id'
    protected $fillable = ['name','product_unit_count','unit_price','total_price', 'cart_id'];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public static function toOrderProduct(CartProduct $cartProduct, int $order_id){
        $orderProduct = new OrderProduct();
        $orderProduct->name = $cartProduct->name;
        $orderProduct->product_unit_count = $cartProduct->product_unit_count;
        $orderProduct->unit_price = $cartProduct->unit_price;
        $orderProduct->total_price = $cartProduct->total_price;
        $orderProduct->order_id = $order_id;
        $orderProduct->save();
    }
}
