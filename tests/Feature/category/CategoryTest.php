<?php

namespace Tests\Feature\category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $categories;
    public function setUp() : void 
    {
        parent::setUp();
        $this->categories = Category::factory(10)->create();
        $this->admin = User::factory()->create(['is_admin' => true]);
        Sanctum::actingAs($this->admin);
    }

    public function test_get_all_categories()
    {
        $this->getJson(route('category.index'))
        ->assertOk()
        ->json();
    }

    public function test_create_on_validation_error()
    {
        $this->postJson(route('category.store'))
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['name']);
    }

    public function test_create_on_success()
    {
        $response = $this->postJson(route('category.store'), ['name' => 'my name'])
        ->assertCreated()
        ->json();
        
        $this->assertNotNull($response['data']);
        $this->assertDatabaseHas('categories', ['name' => 'my name']);
    }

    public function test_show_on_error_not_found()
    {
        $response = $this->getJson(route('category.show', ['category' => 100]))
        ->assertNotFound();
        
        $this->assertNull($response['data']);
    }


    public function test_category_update_on_error_not_found()
    {
        $this->putJson(route('category.update', ['category' => 100]))
        ->assertNotFound();
    }

    public function test_category_on_success()
    {
        $response = $this->putJson(route('category.update', ['category' => 1]), ['name' => 'Ahmed'])
        ->assertOk()
        ->json();

        $this->assertNotNull($response['data']);
        $this->assertDatabaseHas('categories', ['name' => 'Ahmed']);

    }

    public function test_delete_on_success()
    {
        $this->deleteJson(route('category.destroy', ['category' => 1]))
        ->assertOk();

        $this->assertDatabaseMissing('categories', ['id' => 1]);
    }
}
