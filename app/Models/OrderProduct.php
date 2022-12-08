<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = ['name','product_unit_count','unit_price','total_price', 'order_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
