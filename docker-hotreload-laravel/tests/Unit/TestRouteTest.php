<?php

namespace Tests\Feature;

use Tests\TestCase;
use GuzzleHttp\Client;
use App\User;
use App\Test;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;


class TestRouteTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    private $postData = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed'); 
        $this->postData = [
            [
                'user_id' => 11,
                'test_id' => 2,
                'grade' => 5.6
            ],
            [
                'user_id' => 12,
                'test_id' => 2,
                'grade' => 7.9
            ]
        ]; 
    }

    /** @test */
    public function getAllTestsShouldReturnHttpCode200()
    {
        $response = $this->get('/api/tests/');

        $response->assertOk();
    }
    
    /** @test */
    public function getTestShouldReturnJsonObject()
    {
        $response = $this->get('/api/tests/1');

        $response->assertJsonStructure([
            'id',
            'course_id',
            'name',
            'percentage',
            'mandatory',
            'semester',
            'given_at',
            'retake',
            'grades_inserted',
            'created_at',
            'updated_at'
        ]);
    }

    /** @test */
    public function getTestsFromCourseWithoutInsertedShouldReturnAllNotInsertedTests()
    {
        $response = $this->get('/api/tests/course/2');

        $response->assertJsonFragment([
            'grades_inserted' => "0"
        ]);
    }

    /** @test */
    public function GetTestsFromNonExistingCourseShouldReturnHttpCode200()
    {
        $response = $this->get('/api/tests/course/2');

        $response->assertOk();
    }

    /** @test */
    public function getTestsFromCourseWithInsertedTrueShouldReturnEmptyResult()
    {
        $response = $this->get('/api/tests/course/2?inserted=1');

        $response->assertJson([]);
    }

    /** @test */
    public function getTestsFromCourseWithInsertedFalseShouldReturnAllNotInsertedTests()
    {
        $response = $this->get('/api/tests/course/2?inserted=0');

        $response->assertJsonFragment([
            'grades_inserted' => "0"
        ]);
    }

    /** @test */
    public function getStudentsFromTestShouldReturnHttpCode200()
    {
        $response = $this->get('/api/tests/2/students');

        $response->assertOk();
    }

    /** @test */
    public function postGradesForTestShouldReturnHttpCode200()
    {
        $response = $this->json('POST', '/api/tests/2/grades', $this->postData);

        $response->assertOk();
    }

    /** @test */
    public function postGradesForTestShouldReturnJsonObject()
    {

        $response = $this->json('POST', '/api/tests/2/grades', $this->postData);

        $response->assertJsonStructure([
            'id',
            'course_id',
            'name',
            'percentage',
            'mandatory',
            'semester',
            'given_at',
            'retake',
            'grades_inserted',
            'created_at',
            'updated_at'
        ]);
    }

    /** @test */
    public function postGradesForTestShouldReturnUserTestPivot()
    {

        $postRequest = $this->json('POST', '/api/tests/2/grades', $this->postData);

        $response = $this->get('/api/tests/2/grades');

        $response->assertJsonStructure([
            '*' => [
                'pivot' => [
                    'user_id',
                    'test_id',
                    'grade'
                ]
            ]
        ]);

    }
}
