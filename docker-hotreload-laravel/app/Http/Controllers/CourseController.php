<?php

namespace App\Http\Controllers;

use App\Announcement;
use Illuminate\Http\Request;
use App\User;
use App\Course;

class CourseController extends Controller
{
    public function all()
    {
        return Course::all();
    }

    public function show($id)
    {
        return Course::with('announcements')->findOrFail($id);
    }

    public function registerUserToCourse($courseId)
    {
        $userId = auth()->user()->id;
        $course = $this->show($courseId);

        $course->users()->attach($userId, [
            'role' => 'COURSE_STUDENT',
            'showing' => 1
        ]);

        return $course;
    }

    public function unregisterUserToCourse($courseId)
    {
        $userId = auth()->user()->id;
        $course = $this->show($courseId);
        $course->users()->detach($userId);
        return $course;
    }

    public function getFiveLatestAnnouncementForCourse($courseId){
        return Announcement::where('course_id', $courseId)
            ->orderBy('id', 'DESC')
            ->take(5)
            ->get();
    }

    public function getCoursesForUser()
    {
        $userId = auth()->user()->id;

        $courses = Course::whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        return $courses;
    }
    
    public function getAllStudentsForCourse($courseId)
    {
        $course = $this->show($courseId);
        return $course->users()->where('role', 'COURSE_STUDENT')->get();
    }
}
