<?php

namespace Tests\Feature\Traits;

trait LoginTrait
{
    public function login($email, $password)
    {
        $credentials = [
            'email'     => $email,
            'password'  => $password
        ];

        $res = $this->postJson('api/login', $credentials);

        $res->assertStatus(200);

        return $res->getData()->token;
    }
}