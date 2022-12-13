<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class OrderTest extends TestCase
{
    public function test_OrderesApiReturnsJson(){   
        $user = User::factory()->create();
        Auth::login($user);
        $response = $this->getJson('/api/orders');
        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function test_unAuthUserCannotCreateOrder(){
        $response = $this->postJson('/api/orders');
        $response->assertJson([
            "message" => "Unauthenticated."
        ]);
    }

    // public function test_AuthUserCanCreateOrder(){

    //     $user = User::factory()->create(['role'=> 0]);
    //     Auth::login($user);
    //     $response = $this->postJson('/api/orders',[
    //         'customer_id' => $user->id,
    //         'products' => [
    //             // {"product_id":1,"quantity":5},
    //             // {"product_id":1,"quantity":5}
    //         ],
    //     ]);
    //     $response->assertStatus(200);
    // }
}
