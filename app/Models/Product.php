<?php

namespace App\Models;

use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'in_stock', 'sold', 'total_profit', 'rate','unit_price', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public static function decreaseProduct(OrderProduct $orderProduct, Product $product){
        $product->in_stock -= $orderProduct->product_unit_count;
        $product->sold += $orderProduct->product_unit_count;
        $product->total_profit += $orderProduct->total_price;
        $product->save();
    }

    
}
