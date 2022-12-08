<?php

namespace Tests\Feature\OrderProduct;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class OrderProductTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Order $order;
    private $orderProducts;

    public function setUp() : void {
        parent::setUp();
        $this->user=User::factory()->create();
        $this->order = Order::factory()->create(['user_id' => $this->user->id, 'id' => 1]);
        $this->orderProducts = OrderProduct::factory(10)->create()->each(function($orderProduct, $key){
            $orderProduct->order_id = $this->order->id;
        });
        Sanctum::actingAs($this->user);

    }

    public function test_product_index(){
        $this->getJson(route('order-product.order', ['order' => 1]))
        ->assertOk();
    }

    public function test_product_add_to_cart(){
        $this->postJson(route('order-product.add'), [
             'name'=> 'Ahmed',
            'product_unit_count' => random_int(1,4),
            'total_price' => random_int(1,4),
            'unit_price' => random_int(1,3),
            'order_id' => 1
        ])
        ->assertCreated();

        $this->assertDatabaseHas('order_products', ['name' => 'Ahmed']);
    }

    public function test_update_product(){
        $this->put(route('order-product.edit', ['orderProduct' => $this->orderProducts->first()->id]), ['product_unit_count' => 30])
        ->assertOk();

        $this->assertDatabaseHas('order_products', ['product_unit_count' => 30]);
    }

    public function test_delete_product(){
        $this->delete(route('order-product.delete', ['orderProduct'=> 8]))
        ->assertNoContent();

        $this->assertDatabaseMissing('order_products', ['id' => 8]);
    }
    
}
