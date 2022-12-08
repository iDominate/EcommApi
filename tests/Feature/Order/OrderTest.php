<?php

namespace Tests\Feature\Order;

use App\Models\Order;
use App\Models\User;
use App\Enums\OrderStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    private Order $order;
    private User $user;

    public function setUp(): void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->order = Order::factory()->create(['user_id' => $this->user->id]);
        Sanctum::actingAs($this->user);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_change_order_status()
    {
        $this->postJson(route('order.change', ['order' => $this->order->id, 'status' => OrderStatus::Shipping]))
        ->assertOk();
    }

    public function test_delete_order(){
        $this->delete(route('order.delete', ['order' => $this->order->id]))->assertNoContent();
        $this->assertDatabaseCount('orders', 0);
    }
}
