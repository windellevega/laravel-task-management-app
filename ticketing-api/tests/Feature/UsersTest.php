<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function a_user_can_register()
    {
        $user = [
            'first_name'            => 'Juan',
            'last_name'             => 'Dela Cruz',
            'email'                 => 'juandelacruz@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password'
        ];

        $this->postJson('api/register', $user)
            ->assertStatus(201);
    }
}
