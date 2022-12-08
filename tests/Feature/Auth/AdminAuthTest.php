<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;
    
    private $user;

    public function setUp() : void {
        parent::setUp();
        $this->user = User::factory()->create(['is_admin' => true]);
        Sanctum::actingAs($this->user);

    }
    /**
     * check admin Validation Erros
     * @return void
     */
    public function test_admin_login_on_validation_error()
    {
       $this->postJson(route('admin.login'))
       ->assertUnprocessable()
       ->assertJsonValidationErrors(["email", "password"])
       ->json();

       
    }
    /**
     * check login on success
     */
    function test_login_on_success()
    {
        $response = $this->postJson(route("admin.login"), ["email" => $this->user->email, "password" => $this->user->password])
        ->assertOk()
        ->json();
        
        $this->assertEquals($this->user->email, $response["data"][0]["email"]);
    }

    /**
     * Logout out Admin on success
     */
    function logout_admin_logout_on_success()
    {
        $this->postJson(route("admin.logout"))
        ->assertOk();
    }
}
