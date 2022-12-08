<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private $category;
    private $products;
    private $admin;

    public function setUp() : void {
        parent::setUp();
        $this->category = Category::factory()->create();
        $this->products = Product::factory(10)->create()->each(function($product, $key){
            $product->category()->associate($this->category);
        });
        $this->admin = User::factory()->create(['is_admin' => true]);
        Sanctum::actingAs($this->admin);
    }

    public function test_index_on_success()
    {
        $response = $this->getJson(route('category.product.index', $this->category->id))
        ->assertOk()
        ->json();
        
        $this->assertNotNull($response['data']);
    }

    public function test_store_on_validation_error()
    {
        $this->postJson(route('category.product.store', ['category' => $this->category]))
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['name']);
    }

    public function test_store_on_success()
    {
        $response = $this->postJson(route('category.product.store', ['category' => $this->category]), ['name' => 'my name'])
        ->assertCreated()
        ->json();

        $this->assertDatabaseHas('products', ['name' => 'my name']);
        $this->assertNotNull($response['data']);
    }

    public function test_show_on_error_not_found()
    {
        $this->getJson(route('product.show', ['category' => $this->category, 'product' => 100]))
        ->assertNotFound();
    }

    public function test_show_on_success()
    {
        $response = $this->getJson(route('product.show', ['category' => $this->category,'product' => 5]))
        ->assertOk()
        ->json();

        $this->assertNotNull($response['data']);
    }
    public function test_update_on_success()
    {
        $response = $this->putJson(route('product.update', ['category' => $this->category, 'product' => 4]), ['name' => 'my_name'])
        ->assertOk()
        ->json();

        $this->assertDatabaseHas('products', ['name' => 'my_name']);
        $this->assertNotNull($response['data']);
    }

    public function test_delete_on_success()
    {
        $this->deleteJson(route('product.destroy', ['category' => $this->category, 'product' => 8]))
        ->assertOk();

        $this->assertDatabaseMissing('products', ['id' => 8]);
    }
}
