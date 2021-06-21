<?php

namespace Tests\Feature;

use Tests\TestCase;
use GuzzleHttp\Client;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CourseRouteTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    private $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
        $this->user = factory(User::class)->create();   
    }

    /** @test */
    public function getAllCoursesShouldReturnHttpCode200()
    {
        $response = $this->get('/api/courses/');

        $response->assertOk();
    }

    /** @test */
    public function getCourseShouldReturnJsonObject()
    {
        $response = $this->get('/api/courses/1');

        $response->assertJsonStructure([
            'id',
            'spec_id',
            'course_code',
            'course_description',
            'semester',
            'year',
            'ec'
        ]);
    }

    /** @test */
    public function userCanRegisterToCourseShouldReturnHttpCode200()
    {
        $response = $this->actingAs($this->user)->post('/api/courses/1/user');

        $response->assertOk();
    }

    /** @test */
    public function userCannotRegisterToNonExistingCourseShouldReturnHttpCode404()
    {
        $response = $this->actingAs($this->user)->post('/api/courses/10/user');

        $response->assertStatus(404);
    }

    /** @test */
    public function userCannotRegisterMultipleTimesOnTheSameCourseShouldReturnHttpCode200()
    {
        $request = $this->actingAs($this->user)->post('/api/courses/1/user');

        $sameRequest = $this->actingAs($this->user)->post('/api/courses/1/user');

        $sameRequest->assertStatus(200);
    }

    /** @test */
    public function unregisteringAUserFromACourseShouldReturnHttpCode200()
    {
        $registeredUserToCourse = $this->actingAs($this->user)->post('/api/courses/1/user');

        $userToDelete = $this->actingAs($this->user)->delete('/api/courses/1/user');

        $userToDelete->assertOk();
    }

    /** @test */
    public function unregisteringANonExistingUserFromACourseShouldReturnHttpCode200()
    {
        $userToDelete = $this->actingAs($this->user)->delete('/api/courses/2/user');

        $userToDelete->assertOk();
    }
}
