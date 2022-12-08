<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'number_of_products', 'total_items_in_stock', 'total_profit', 'total_items_sold'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
