<?php
/**
 * Created by PhpStorm.
 * User: dylba
 * Date: 15-May-19
 * Time: 14:43
 */

namespace App\Http\Controllers;

use App\Announcement;
use App\Course;
use App\Test;
use Illuminate\Http\Request;
use App\User;

class StudentController extends Controller
{
    public function getECPerYear()
    {
        $user = auth()->user();
        $ECPerYear = Course::where('test_user.grade','>',5.4)
            ->where('test_user.user_id', '=', $user->id)
            ->join('course_user', 'course_user.course_id', '=', 'courses.id')
            ->join('tests', 'tests.course_id', '=', 'courses.id')
            ->join('test_user', 'test_user.test_id', 'tests.id')
            ->distinct()
            ->get(['courses.id', 'courses.ec', 'courses.year'])
            ->groupBy('year')
            ->map(function($course){
                return (int) $course->sum('ec');
            });
        return $ECPerYear;
    }

    public function getCourses(Request $request)
    {
        $showing = $request->query('showing');
        $user = auth()->user();
        $courses = $user->courses()
            ->when(($showing) || ($showing === "0"), function ($query) use ($showing) {
                return $query->where('showing', '=', $showing);
            })
            ->orderBy('id', 'DESC')->get();
        return $courses;
    }

    public function getAnnouncementsForSubscribedCourses(Request $request)
    {
        $limit = $request->query('limit', '100');

        $user = User::find(auth()->user()->id);
        $announcements = Announcement::whereIn(
            'course_id', $user->courses()->pluck('courses.id')->toArray()
        )->orderBy('id', 'DESC')->take($limit)->get();

        return $announcements;
    }

    public function getGrades(Request $request)
    {
        $limit = $request->query('limit');
        $user = auth()->user();
        $grades = $user->Tests()->where('grade', '>', 0)->take($limit)->get();
        return $grades;
    }
}