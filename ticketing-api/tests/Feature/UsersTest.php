<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersTest extends TestCase
{
    /**
     * 
     * Test feature api/register
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
            ->assertStatus(201)
            ->assertJsonStructure(['user', 'token']);
    }

    /**
     * 
     * Test feature api/login
     *
     * @test
     */
    public function a_user_can_login()
    {
        $user = [
            'email'                 => 'admin@example.com',
            'password'              => 'password'
        ];

        $this->postJson('api/login', $user)
            ->assertStatus(201)
            ->assertJsonStructure(['user', 'token']);
    }

    /**
     * 
     * Test feature api/login
     *
     * @test
     */
    public function a_user_can_logout()
    {
        $user = User::where('email', 'admin@example.com')
                    ->first();

        $token = $user->createToken('TicketingAPI')->plainTextToken;

        $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->post('api/logout')
            ->assertJson(['message' => 'Logged out.']);
    }
}
