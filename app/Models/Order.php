<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $fillable = ['id', "name_of_owner", "email_of_owner","user_id","number_of_products","number_of_items","total_price", "status", "order_date"];

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
