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
        $user = User::factory()->create();
        $product = Product::factory()->create(['added_by' => $user->id]);

        $response = $this->patchJson('/api/products/' . $product->id, []);
        $response->assertJson([
            "message" => "Unauthenticated."
        ]);
    }

    public function testUnauthUserCanNotDeleteProduct()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['added_by' => $user->id]);

        $response = $this->deleteJson('/api/products/' . $product->id);
        $response->assertJson([
            "message" => "Unauthenticated."
        ]);
    }

    public function testAuthSellerUserCanCreateProduct()
    {
        $sellerUser = User::factory()->create(['role' => 1]);
        Auth::login($sellerUser);
        $response = $this->postJson('/api/products', [
            'added_by' => $sellerUser->id,
            'name' => 'product',
            'amount_avilable' => 5,
            'cost' => 5,
        ]);
        $response->assertOk();
    }

    public function testAuthSellerUserCanUpdateHisProduct()
    {
        $sellerUser = User::factory()->create(['role' => 1]);
        $product = Product::factory()->create(['added_by' => $sellerUser->id]);
        Auth::login($sellerUser);
        $response = $this->patchJson('/api/products/' . $product->id, [
            'name' => 'product',
            'amount_avilable' => 6,
            'cost' => 5,
        ]);
        $response->assertOk();
    }

    public function testAuthSellerUserCanDeleteHisProduct()
    {
        $sellerUser = User::factory()->create(['role' => 1]);
        $product = Product::factory()->create(['added_by' => $sellerUser->id]);
        Auth::login($sellerUser);
        $response = $this->deleteJson('/api/products/' . $product->id);
        $response->assertOk();
    }
    
    public function testAuthSellerUserCanNotUpdateOtherThanHisProducts()
    {
        $this->withoutExceptionHandling();
        $sellerForAuth = User::factory()->create(['role' => 1]);
        $sellerForAddProduct = User::factory()->create(['role' => 1]);
        $product = Product::factory()->create(['added_by' => $sellerForAddProduct->id]);

        Auth::login($sellerForAuth);
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
        $sellerForAuth = User::factory()->create(['role' => 1]);
        $sellerForAddProduct = User::factory()->create(['role' => 1]);
        $product = Product::factory()->create(['added_by' => $sellerForAddProduct->id]);

        Auth::login($sellerForAuth);
        $response = $this->deleteJson('/api/products/' . $product->id);
        $response->assertJson([
            'status' => 'Error',
            'message' => 'You don’t have permission to access this product',
            'data' => NULL,
        ]);
    }

    public function testAuthBuyerUserCanNotCreateProduct()
    {
        $buyerUser = User::factory()->create(['role' => 0]);
        Auth::login($buyerUser);
        $response = $this->postJson('/api/products', []);
        $response->assertJson([
            "status" => "Error",
            "message" => "You don't have permission to access this route",
            "data" => null
        ]);
    }

    public function testAuthBuyerUserCanNotUpdateProduct()
    {
        $buyerUser = User::factory()->create(['role' => 0]);
        $product = Product::factory()->create(['added_by' => $buyerUser->id]);
        Auth::login($buyerUser);
        $response = $this->patchJson('/api/products/' . $product->id, []);
        $response->assertJson([
            "status" => "Error",
            "message" => "You don't have permission to access this route",
            "data" => null
        ]);
    }

    public function testAuthBuyerUserCanNotDeleteProduct()
    {
        $buyerUser = User::factory()->create(['role' => 0]);
        $product = Product::factory()->create(['added_by' => $buyerUser->id]);
        Auth::login($buyerUser);
        $response = $this->deleteJson('/api/products/' . $product->id);
        $response->assertJson([
            "status" => "Error",
            "message" => "You don't have permission to access this route",
            "data" => null
        ]);
    }
}
