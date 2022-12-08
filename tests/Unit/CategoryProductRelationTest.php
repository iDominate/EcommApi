<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class CategoryProductRelationTest extends TestCase
{
    use RefreshDatabase;
    
    private $category;
    private $products;
    public function setUp() : void {
        parent::setUp();
        $this->category = Category::factory()->create();
        $this->products = Product::factory(10)->create()->each(function($product, $key){
            $product->category()->associate($this->category->id);
            
        });
    }

    public function test_category_has_many_products()
    {
        $this->assertDatabaseCount('products', 10);
        $this->assertInstanceOf(Collection::class, $this->category->products);
        $this->assertInstanceOf(Category::class, $this->products->first()->category);
    }
}
