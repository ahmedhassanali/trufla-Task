<?php

namespace Tests\unit;

use Tests\TestCase;
use App\Models\User;

class userTest extends TestCase
{
    public function testUserCreation()
    {
        $user = new User([
            'name' => "Test User",
            'user-name' => "test@mail.com",
            'password' => bcrypt("123456789")
        ]);   

        $this->assertEquals('Test User', $user->name);
    }
}