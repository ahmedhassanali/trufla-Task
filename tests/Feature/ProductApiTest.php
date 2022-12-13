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
    
    public function test_ProductesApiReturnsJson(){   
        $user = User::factory()->create();
        Auth::login($user);
        $response = $this->getJson('/api/products');
        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function test_unAuthUserCanNotCreateProduct(){
        $response = $this->postJson('/api/products');
        $response->assertJson([
            "message" => "Unauthenticated."
        ]);
    }

    public function test_AuthSellerUserCanCreateProduct(){

        $user = User::factory()->create(['role'=> 1]);
        Auth::login($user);
        $response = $this->postJson('/api/products',[
            'added_by' => $user->id,
            'name' => 'product',
            'amount_avilable' => 5,
            'cost' => 5,
        ]);

        $response->assertStatus(200);

    }

    // public function test_unAuthUserCanNotUpdateProduct(){
    //     $user = User::factory()->create(['role'=> 1]);
    //     $product = Product::factory()->create(['added_by'=>$user->id]);

    //     $response = $this->patchJson('/api/products'.$product->id,[
    //         'name' => 'product',
    //         'amount_avilable' => 6,
    //         'cost' => 5,
    //     ]);

    //     $response->assertJson([
            
    //     ]);
    // }

    public function test_AuthSellerUserCanUpdateHisProduct(){
        $user = User::factory()->create(['role'=> 1]);
        $product = Product::factory()->create(['added_by'=>$user->id]);
        Auth::login($user);
        $response = $this->patchJson('/api/products/'.$product->id,[
            'name' => 'product',
            'amount_avilable' => 6,
            'cost' => 5,
        ]);

        $response->assertStatus(200);

    }

    // public function test_AuthSellerUserCanNotUpdateOtherThanHisProducts(){
    //     $user1 = User::factory()->create(['role'=> 1]);
    //     $user2 = User::factory()->create(['role'=> 1]);
    //     $product = Product::factory()->create(['added_by'=>$user2->id]);

    //     Auth::login($user1);
    //     $response = $this->patchJson('/api/products/'.$product->id,[
    //         'name' => 'product',
    //         'amount_avilable' => 6,
    //         'cost' => 5,
    //     ]);

    //     $response->assertStatus(200);

    // }

    // public function test_AuthSellerUserCanNotDeleteOtherThanHisProducts(){
    //     $user1 = User::factory()->create(['role'=> 1]);
    //     $user2 = User::factory()->create(['role'=> 1]);
    //     $product = Product::factory()->create(['added_by'=>$user2->id]);

    //     Auth::login($user1);
    //     $response = $this->deleteJson('/api/products/'.$product->id);


    //     $response->assertStatus(200);

    // }

    // public function test_unAuthUserCanNotDeleteProduct(){
    //     $user = User::factory()->create(['role'=> 1]);
    //     $product = Product::factory()->create(['added_by'=>$user->id]);

    //     $response = $this->deleteJson('/api/products'.$product->id);
    //     $response->assertJson([
    //         "message" => "Unauthenticated."
    //     ]);
    // }

    public function test_AuthSellerUserCanDeleteProduct(){
        $user = User::factory()->create(['role'=> 1]);
        $product = Product::factory()->create(['added_by'=>$user->id]);
        Auth::login($user);
        $response = $this->deleteJson('/api/products/'.$product->id);
        $response->assertStatus(200);
    }

    public function test_AuthBuyerUserCanNotCreateProduct(){

        $user = User::factory()->create(['role'=> 0]);
        Auth::login($user);
        $response = $this->postJson('/api/products',[
            'added_by' => $user->id,
            'name' => 'product',
            'amount_avilable' => 5,
            'cost' => 5,
        ]);

        $response->assertJson([
            "You don't have permission to access this route"
        ]);
    }

    // public function test_AuthBuyerUserCanNotUpdateProduct(){
    //     $user = User::factory()->create(['role'=> 0]);
    //     $product = Product::factory()->create(['added_by'=>$user->id]);
    //     Auth::login($user);
    //     $response = $this->patchJson('/api/products'.$product->id,[
    //         'name' => 'product',
    //         'amount_avilable' => 6,
    //         'cost' => 5,
    //     ]);
    //     $response->assertJson([
    //         "You don't have permission to access this route"
    //     ]);
    // }

    public function test_AuthBuyerUserCanNotDeleteProduct(){
        $user = User::factory()->create(['role'=> 0]);
        $product = Product::factory()->create(['added_by'=>$user->id]);
        Auth::login($user);
        $response = $this->deleteJson('/api/products/'.$product->id);
        $response->assertJson([
            "You don't have permission to access this route"
        ]);
    }
}
