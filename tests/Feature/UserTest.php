<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Support\Str;

class UserTest extends TestCase
{
 
    use RefreshDatabase;

    public function test_Login()
    {
        User::factory()->create([
            'name' => 'buyer',
            'user_name' => 'buyer',
            'role'=> 0,
            'password' => Hash::make('123456789'),
            'remember_token' => Str::random(10),
        ]);

        $response = $this->post('/api/login',[
            'user_name' => 'buyer',
            'password' => '123456789',
        ]);

        $response->assertOk();
    }

    public function test_createUser()
    {
       $response = $this->postJson('/api/users',[
        'name' => 'ahmed',
        'user_name' => 'ahmed_h',
        'role'=> 0,
        'password' => Hash::make('123456789'),
        'remember_token' => Str::random(10),
       ]);

        $response->assertOk();
    }

    
}
