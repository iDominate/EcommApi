<?php

namespace Tests\Feature\Cart;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $cart;
    private $cartProducts;

    public function setUp() : void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->cart = Cart::factory()->create(['user_id'=>$this->user->id]);
        $this->cartProducts = CartProduct::factory(10)->create()->each(function($cartProduct, $key){
            $cartProduct->cart_id = $this->cart->id;
        });
        Sanctum::actingAs($this->user);
    }
    public function test_cart_on_success()
    {
        $this->getJson(route('cart.index'))
        ->assertOk();
    }

    public function test_clear_cart(){
        $this->deleteJson(route('cart.clear'))
        ->assertNoContent();
        $this->assertDatabaseCount('cart_products', 0);
    }
}
