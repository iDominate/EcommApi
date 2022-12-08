<?php

namespace Tests\Feature\CartProduct;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CartProductTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $cart;
    private $cartProducts;

    public function setUp() : void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->cart = Cart::factory()->create(['user_id' => $this->user->id]);
        $this->cartProducts = CartProduct::factory(10)->create()->each(function($cartProduct, $key){
            $cartProduct->cart()->associate($this->cart);
        });
        Sanctum::actingAs($this->user);
    }

    public function test_index_on_success()
    {
        $response = $this->getJson(route('cart-product.index'))
        ->assertOk()
        ->json();

        $this->assertCount(5, $response['data']['data']);
        $this->assertNotEmpty($response['data']);
    }

    public function test_store_on_validation_error()
    {
        $this->postJson(route('cart-product.store'),)
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['total_price', 'product_unit_count', 'unit_price']);
    }

    public function test_store_on_success()
    {
        $response = $this->postJson(route('cart-product.store'), [
            'total_price' => random_int(1, 4),
            'product_unit_count' => random_int(1, 4),
            'unit_price' => random_int(1, 4),
            'name' => 'my name'])
        ->assertCreated()
        ->json();
        $this->assertArrayHasKey('name', $response['data']);
    }

    public function test_show_on_success()
    {
        $this->getJson(route('cart-product.show', ['cart_product'=> 1]))
        ->assertOk();
    }

    public function test_update_on_validation_error()
    {
        $this->putJson(route('cart-product.update', ['cart_product' => 1]), ['name' => 'my name'])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('name');
    }

    public function test_update_on_success()
    {
        $this->putJson(route('cart-product.update', ['cart_product' => 4]), ['name' => 'my_name'])
        ->assertOk();

        $this->assertDatabaseHas('cart_products', ['name' => 'my_name']);
    }

    public function test_delete_on_success()
    {
        $this->deleteJson(route('cart-product.destroy', ['cart_product' => 4]))
        ->assertOk();

        $this->assertDatabaseMissing('cart_products', ['id' => 4]);
    }

    public function test_get_cart_products(){
        $response = $this->getJson(route('cart.products', ['cart'=> $this->cart->id]))
        ->assertOk();
        //dd($response);
    }
}
