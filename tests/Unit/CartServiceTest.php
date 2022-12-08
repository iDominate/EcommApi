<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Services\CartService;
use Laravel\Sanctum\Sanctum;

class CartServiceTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp() : void {
        parent::setUp();
        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);
    }
    public function test_create_cart()
    {
        $cart = CartService::create(user_id: 1,
         number_of_products: random_int(0,1000),
         number_of_items: random_int(0, 1000),
         total_price: random_int(0,100000));
        $this->assertNotNull($cart);
    }
}
