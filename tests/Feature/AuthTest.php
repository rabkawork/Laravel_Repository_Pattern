<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_wrong_login()
    {
        $payload = [
            "email" => "admin@egmail.com",
            "password" => "password"
        ];

        $this->post('/api/login', $payload)->assertStatus(401)
        ->assertJsonStructure(
            [
                'status',
                'message',
                'error',
            ]
            );
    }


    public function test_success_register()
    {
        $payload = [
            "email" => rand(10,100)."@gmail.com",
            "password" => "password",
            "name" => "Ahadian",
            "permission" => 2, // regular user
        ];

        $this->post('/api/register', $payload)->assertStatus(200)
        ->assertJsonStructure(
            [
                'status',
                'message',
                'data',
            ]
            );
    }

}
