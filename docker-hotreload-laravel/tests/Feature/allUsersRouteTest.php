<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class allUsersRouteTest extends TestCase
{

    use DatabaseMigrations;
    use WithoutMiddleware;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    /** @test */
    public function getAllUsersShouldReturnHTTPCode200()
    {
        $response = $this->get('/api/users');

        $response->assertStatus(200);
    }

    /** @test */
    public function getUserShouldReturnJsonObject()
    {
        $response = $this->get('/api/users/1');

        $response->assertJsonStructure([
            'id',
            'first_name',
            'last_name',
            'email',
            'email_verified_at',
            'created_at',
            'updated_at'
        ]);
    }
}
