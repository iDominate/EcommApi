<?php

namespace Tests\Unit;

use App\Models\Cart;
use App\Models\CartProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class CartHasProductTest extends TestCase
{
    use RefreshDatabase;

    private $cart;
    private $cartProducts;

   public function setUp() : void 
   {
        parent::setUp();
        $this->cart = Cart::factory()->create();
        $this->cartProducts = CartProduct::factory(10)->create()->each(function($cartProduct, $key){
            $cartProduct->cart()->associate($this->cart);
        });
   }

   public function test_cart_has_products()
   {
     $this->assertInstanceOf(Collection::class, $this->cart->cart_products);
     $this->assertInstanceOf(Cart::class, $this->cartProducts->first()->cart);
   }
}
