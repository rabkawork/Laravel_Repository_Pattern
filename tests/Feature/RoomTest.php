<?php

namespace Tests\Feature;

use App\Models\User;
use App\Service\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RoomTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_data()
    {
        $response = $this->get('/api/rooms');
        $response->assertStatus(200);
    }

    public function test_wrong_post_data()
    {
        Sanctum::actingAs(
            User::where('permission',1)->first(),
        );

        $response = $this->json('POST', "/api/rooms", [
            'password' => 'testpassword',
        ]);

        $response->assertStatus(400)
            ->assertJsonStructure(['status', 'error']);
    }

}
