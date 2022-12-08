<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserAuthTest extends TestCase
{
    use RefreshDatabase;

    public $user;

    public function setUp() : void {
        parent::setUp();
        $this->user = User::factory()->create(['is_admin'=> false]);
        Sanctum::actingAs($this->user);
    }

    public function test_register_on_validation_error()
    {
        $this->postJson(route('user.register'))
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    public function test_register_on_success()
    {
        $response = $this->postJson(route('user.register'), ['name' => 'Anthony',
         'email' => "anthony@gmail.com",
          'password' => '12345',
           'password_confirmation' => '12345'])
        ->assertCreated()
        ->json();

        $this->assertDatabaseHas('carts', ['user_id' => 2]);
        $this->assertEquals('Success', $response['message']);
        $this->assertDatabaseHas('users', ['name' => 'Anthony']);
        $this->assertDatabaseCount('users', 2);
    }

    public function test_login_on_validation_error()
    {
        $this->postJson(route('user.login'))
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email', 'password']);
    }

    public function test_user_password_not_correct()
    {
        $this->postJson(route('user.login'), [ 'email' => $this->user->email,'password' => '12345'])
        ->assertForbidden();
    }

    public function test_login_on_success()
    {
        $response = $this->postJson(route('user.login'), [
         'email' => $this->user->email,
          'password' => $this->user->password,
           ])
        ->assertOk()
        ->json();

        $this->assertArrayHasKey("data", $response);
        $this->assertNotNull($response["data"]);
        $this->assertArrayHasKey("token", $response['data']);
        $this->assertEquals('Success', $response['message']);
    }

    public function test_logout_on_success()
    {
        $this->postJson(route('user.logout'))
        ->assertOk();
    }
}
