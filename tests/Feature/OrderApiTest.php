<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\DBAL\TimestampType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function testOrderesApiReturnsJson(){  

        $user = User::factory()->create();
        Auth::login($user);
        $response = $this->getJson('/api/orders');
        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/json');

    }

    public function testUnauthUserCannotCreateOrder(){
        $response = $this->postJson('/api/orders');
        $response->assertJson([
            "message" => "Unauthenticated."
        ]);
    }

    public function testAuthBuyerUserCanCreateOrder(){

        $userSeller = User::factory()->create(['role' => 1]);
        Auth::login($userSeller);

        $product1 = Product::factory()->create(['added_by'=>$userSeller->id]);
        $product2 = Product::factory()->create(['added_by'=>$userSeller->id]);

        $userBuyer = User::factory()->create(['role'=> 0]);
        Auth::login($userBuyer);

        $response = $this->postJson('/api/orders', [
            "customer_id" => $userBuyer->id,
            "products" => [
                ["product_id"=>$product1->id,"quantity"=>5],
                ["product_id"=>$product2->id,"quantity"=>6]
            ]
        ]);

       $response->assertOk();
    }

    public function testAuthSellerUserCanNotCreateOrder(){

        $userSeller = User::factory()->create(['role' => 1]);
        Auth::login($userSeller);

        $response = $this->postJson('/api/orders', []);
        $response->assertJson([
            "status" => "Error",
            "message" => "You don't have permission to access this route",
            "data" => null
        ]);
    }

}
