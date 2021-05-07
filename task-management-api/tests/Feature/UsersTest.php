<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UsersTest extends TestCase
{
    /**
     * 
     * Test feature api/register
     *
     * @test
     */
    public function testUserCanRegister()
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
    public function testUserCanLogin()
    {
        $user = [
            'email'                 => 'admin@example.com',
            'password'              => 'password'
        ];

        $this->postJson('api/login', $user)
            ->assertStatus(200)
            ->assertJsonStructure(['user', 'token']);
    }

    /**
     * 
     * Test feature api/user
     *
     * @test
     */
    public function testUserCanGetInformation()
    {
        $token = $this->login('admin@example.com', 'password');

        $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson('api/user')
            ->assertJsonStructure(['id', 'first_name', 'last_name', 'email'])
            ->assertJson(['email' => 'admin@example.com']);
            
    }

    /**
     * 
     * Test feature api/logout
     *
     * @test
     */
    public function testUserCanLogout()
    {
        $token = $this->login('admin@example.com', 'password');

        $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->post('api/logout')
            ->assertJson(['message' => 'Logged out.']);
    }

    /**
     * 
     * Test routes api/user with unauthenticated user
     *
     * @test
     */
    public function testUnauthenticatedUserCannotAccessGetUser()
    {
        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->getJson('api/user');
    }

    /**
     * 
     * Test route api/logout with unauthenticated user
     *
     * @test
     */
    public function testUnauthenticatedUserCannotAccessLogout()
    {
        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->postJson('api/logout');
    }
}
