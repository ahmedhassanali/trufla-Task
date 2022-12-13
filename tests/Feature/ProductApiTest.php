<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Support\Str;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function testProductesApiReturnsJson()
    {
        $user = User::factory()->create();
        Auth::login($user);
        $response = $this->getJson('/api/products');
        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function testUnauthUserCanNotCreateProduct()
    {
        $response = $this->postJson('/api/products');
        $response->assertJson([
            "message" => "Unauthenticated."
        ]);
    }

    public function testUnauthUserCanNotUpdateProduct()
    {
        $user = User::factory()->create(['role' => 1]);
        $product = Product::factory()->create(['added_by' => $user->id]);

        $response = $this->patchJson('/api/products/' . $product->id, []);

        $response->assertJson([
            "message" => "Unauthenticated."
        ]);
    }

    public function testUnauthUserCanNotDeleteProduct()
    {
        $user = User::factory()->create(['role' => 1]);
        $product = Product::factory()->create(['added_by' => $user->id]);

        $response = $this->deleteJson('/api/products/' . $product->id);
        $response->assertJson([
            "message" => "Unauthenticated."
        ]);
    }

    public function testAuthSellerUserCanCreateProduct()
    {
        $user = User::factory()->create(['role' => 1]);
        Auth::login($user);
        $response = $this->postJson('/api/products', [
            'added_by' => $user->id,
            'name' => 'product',
            'amount_avilable' => 5,
            'cost' => 5,
        ]);
        $response->assertOk();
    }

    public function testAuthSellerUserCanUpdateHisProduct()
    {
        $user = User::factory()->create(['role' => 1]);
        $product = Product::factory()->create(['added_by' => $user->id]);
        Auth::login($user);
        $response = $this->patchJson('/api/products/' . $product->id, [
            'name' => 'product',
            'amount_avilable' => 6,
            'cost' => 5,
        ]);
        $response->assertOk();
    }

    public function testAuthSellerUserCanDeleteHisProduct()
    {
        $user = User::factory()->create(['role' => 1]);
        $product = Product::factory()->create(['added_by' => $user->id]);
        Auth::login($user);
        $response = $this->deleteJson('/api/products/' . $product->id);
        $response->assertStatus(200);
    }
    
    public function testAuthSellerUserCanNotUpdateOtherThanHisProducts()
    {
        $user1 = User::factory()->create(['role' => 1]);
        $user2 = User::factory()->create(['role' => 1]);
        $product = Product::factory()->create(['added_by' => $user2->id]);

        Auth::login($user1);
        $response = $this->patchJson('/api/products/' . $product->id, [
            'name' => 'product',
            'amount_avilable' => 6,
            'cost' => 5,
        ]);

        $response->assertJson([
            'status' => 'Error',
            'message' => 'You don’t have permission to access this product',
            'data' => NULL,
        ]);
    }

    public function testAuthSellerUserCanNotDeleteOtherThanHisProducts()
    {
        $user1 = User::factory()->create(['role' => 1]);
        $user2 = User::factory()->create(['role' => 1]);
        $product = Product::factory()->create(['added_by' => $user2->id]);

        Auth::login($user1);
        $response = $this->deleteJson('/api/products/' . $product->id);
        $response->assertJson([
            'status' => 'Error',
            'message' => 'You don’t have permission to access this product',
            'data' => NULL,
        ]);
    }

   

    public function testAuthBuyerUserCanNotCreateProduct()
    {

        $user = User::factory()->create(['role' => 0]);
        Auth::login($user);
        $response = $this->postJson('/api/products', []);
        $response->assertJson([
            "status" => "Error",
            "message" => "You don't have permission to access this route",
            "data" => null
        ]);
    }

    public function testAuthBuyerUserCanNotUpdateProduct()
    {
        $user = User::factory()->create(['role' => 0]);
        $product = Product::factory()->create(['added_by' => $user->id]);
        Auth::login($user);
        $response = $this->patchJson('/api/products/' . $product->id, []);
        $response->assertJson([
            "status" => "Error",
            "message" => "You don't have permission to access this route",
            "data" => null
        ]);
    }

    public function testAuthBuyerUserCanNotDeleteProduct()
    {
        $user = User::factory()->create(['role' => 0]);
        $product = Product::factory()->create(['added_by' => $user->id]);
        Auth::login($user);
        $response = $this->deleteJson('/api/products/' . $product->id);
        $response->assertJson([
            "status" => "Error",
            "message" => "You don't have permission to access this route",
            "data" => null
        ]);
    }
}
