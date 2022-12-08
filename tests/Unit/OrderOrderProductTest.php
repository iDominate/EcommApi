<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class OrderOrderProductTest extends TestCase
{
    use RefreshDatabase;

    private $order;
    private $orderProducts;
    public function setUp() : void 
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->order = Order::factory()->create(['user_id' => 1]);
        $order = $this->order;
        $this->orderProducts = OrderProduct::factory(10)->create();
    }

    public function test_order_has_products()
    {
        $this->assertInstanceOf(Order::class, $this->orderProducts->first()->order);
        $this->assertInstanceOf(Collection::class, $this->order->orderProducts);
    }
}
