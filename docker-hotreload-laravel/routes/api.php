<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'users', 'middleware' => 'auth:api'], function(){
    Route::get('/{id}', 'UserController@show')->middleware('currentUser');
    Route::get('/', 'UserController@all');
});

Route::group(['prefix' => 'tests', 'middleware' => ['auth:api', 'hasRole:teacher']], function() {
    Route::get('/', 'TestController@all');
    Route::get('/{id}', 'TestController@show');
    Route::get('/course/{id}/{inserted?}', 'TestController@getAllTestsForCourse');
    Route::get('/{id}/students', 'TestController@getAllStudentsFromTest');
    Route::post('/{id}/grades', 'TestController@insertGradesForStudents');
    Route::get('/{id}/grades', 'TestController@getGradesForStudents');
});

Route::group(['prefix' => 'courses', 'middleware' => 'auth:api'], function(){
    Route::get('/user', 'CourseController@getCoursesForUser');
    Route::post('/{courseId}/users/{userId}/register', 'CourseController@registerUserToCourse');
    Route::get('/{id}', 'CourseController@show');
    Route::get('/announcements/{id}', 'CourseController@getFiveLatestAnnouncementForCourse');
    Route::get('/announcement/{id}', 'AnnouncementController@Show');
    Route::get('/', 'CourseController@all');
    Route::get('/{courseId}/students', 'CourseController@getAllStudentsForCourse')->middleware('hasRole:teacher');
    Route::post('/{courseId}/user', 'CourseController@registerUserToCourse')->middleware('userRegisteredOnCourse');
    Route::post('/{courseId}/grades', 'CourseController@insertGradesForStudents')->middleware('hasRole:teacher');
    Route::delete('/{courseId}/user', 'CourseController@unregisterUserToCourse')->middleware('userNotRegisteredOnCourse');
});

Route::group(['prefix' => 'student', 'middleware' => 'auth:api'], function(){
   Route::get('/ECPerYear', 'StudentController@getECPerYear');
   Route::get('/courses/{showing?}', 'StudentController@getCourses');
   Route::get('/announcements/{limit?}', 'StudentController@getAnnouncementsForSubscribedCourses');
   Route::get('/grades/{limit?}', 'StudentController@getGrades');
});

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

route::group(['prefix' => 'grades'], function() {
    route::get('all', 'gradeController@all');
});
