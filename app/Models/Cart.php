<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','number_of_products', 'number_of_items', 'total_price'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cart_products()
    {
        return $this->hasMany(CartProduct::class, 'cart_id');
    }
}
