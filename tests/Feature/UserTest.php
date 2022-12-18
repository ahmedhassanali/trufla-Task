<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Support\Str;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testRegister()
    {
        $response = $this->postJson('/api/users', [
            'name' => 'ahmed',
            'user_name' => 'ahmed_h',
            'role' => 0,
            'password' => Hash::make('123456789'),
            'remember_token' => Str::random(10),
        ]);
        $response->assertOk();
    }

    public function testLogin()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $response = $this->post('/api/login', [
            'user_name' => $user->user_name,
            'password' => '123456789',
        ]);
        $this->assertAuthenticated();
        $response->assertOk();
    }

    public function testUserCanNotLoginteWithInvalidPassword()
    {
        $user = User::factory()->create();

        $response = $this->post('/api/login', [
            'user_name' => $user->user_name,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function testLogout()
    {

        $user = User::factory()->create();
        Auth::login($user);
        $response = $this->post('/api/logout');
        $response->assertOk();
        $response->assertJson([
            'status' => 'Success',
            'message' => 'Successfully logged out',
            'data' => NULL,
        ]);
    }

    public function testUnauthUserCanNotUpdateUser()
    {
        $user = User::factory()->create();
        $response = $this->patchJson('/api/users/' . $user->id, []);
        $response->assertJson([
            "message" => "Unauthenticated."
        ]);
    }

    public function testUnauthUserCanNotDeleteUser()
    {
        $user = User::factory()->create();
        $response = $this->deleteJson('/api/users/' . $user->id);
        $response->assertJson([
            "message" => "Unauthenticated."
        ]);
    }

    public function testAuthUserCanUpdateUserData()
    {
        $user = User::factory()->create();
        Auth::login($user);
        $response = $this->patchJson('/api/users/' . $user->id, [
            'name' => 'Name',
            'user_name' => 'userName',
            'role' => 0,
            'password' => Hash::make('123456789'),
        ]);
        $response->assertOk();
    }

    public function testAuthUserCanDeleteUser()
    {
        $user = User::factory()->create();
        Auth::login($user);
        $response = $this->deleteJson('/api/users/' . $user->id);
        $response->assertOk();
    }
}
