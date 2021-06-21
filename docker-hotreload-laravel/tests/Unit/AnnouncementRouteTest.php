<?php

namespace Tests\Feature;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AnnouncementRouteTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;


    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed'); 
    }

    /** @test */
    public function getAnnouncementShouldReturnHttpCode200()
    {
        $response = $this->get('/api/courses/announcements/2');

        $response->assertOk();
    }

    /** @test */
    public function getAnnouncementsShouldReturnJsonObject()
    {
        $response = $this->get('/api/courses/announcements/2');

        $response->assertJsonStructure([
                '*' => [
                    'id',
                    'course_id',
                    'announcement',
                    'created_at',
                    'updated_at',
                    'formatted_created_at'
                ]
        ]);
    }

}
