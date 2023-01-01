<?php

namespace Tests\Feature;

use App\Models\User;
use App\Service\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class KostTest extends TestCase
{



    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_data()
    {
        $response = $this->get('/api/kosts');
        $response->assertStatus(200);
    }

    public function test_wrong_post_data()
    {
        Sanctum::actingAs(
            User::where('permission',1)->first(),
        );

        $response = $this->json('POST', "/api/kosts", [
            'password' => 'testpassword',
        ]);

        $response->assertStatus(400)
            ->assertJsonStructure(['status', 'error']);
    }


    public function test_wrong_access_for_post_data()
    {
        Sanctum::actingAs(
            User::where('permission',2)->first(), // using user regular to create data
        );

        $response = $this->json('POST', "/api/kosts", [
            'name' => 'test'.time(),
            'city' => 'test'.time(),
            'address' => 'test'.time(),
            'phone' => '0811112',
            'location' => 'Malang',
            'description' => 'test',
        ]);

        $response->assertStatus(403)
            ->assertJsonStructure(['status', 'error']);
    }
}
