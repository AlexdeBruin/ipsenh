<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Test;

class TestController extends Controller
{

    private $validation = [
        '*.user_id' => 'required|integer',
        '*.grade' => 'required|between:0,10',
        '*.test_id' => 'required|integer'
    ];

    public function show($id)
    {
        return Test::query()->findOrFail($id);
    }

    public function all()
    {
        return Test::all();
    }
    
    public function getAllTestsForCourse(Request $request, $courseId)
    {
        $inserted = $request->query('inserted');

        $tests = Test::where('course_id', '=', $courseId)
        ->when(($inserted) || ($inserted === "0"), function ($query) use ($inserted) {
            return $query->where('grades_inserted', '=', $inserted);
        })->get();
        
        return $tests;
    }

    public function getAllStudentsFromTest($testId)
    {
        $test = $this->show($testId);
        $users = $test->users()->whereHas('roles', function($query) {
            $query->where('name', '=', 'student');
        })->get();
        return $users;
    }
    
    public function insertGradesForStudents($testId, Request $request)
    {
        $request->validate($this->validation);
        $test = $this->show($testId);
        $requestData = $request->post();
        $this->updateTestUserPivotTable($test, $requestData);
        $this->setGradesInsertedToTrue($testId);
        return $test;
    }

    private function updateTestUserPivotTable($test, $requestBody)
    {
        foreach($requestBody as $requestData)
        {
            $user_id = $requestData['user_id'];
            $grade = $requestData['grade'];
            $updateQuery = $test->users()->updateExistingPivot($user_id, ['grade' => $grade]);
        }
    }

    private function setGradesInsertedToTrue($testId)
    {
        $test = $this->show($testId);
        $test->grades_inserted = true;
        $test->save();
    }

    public function getGradesForStudents($testId)
    {
        $test = $this->show($testId);
        $studentsWithPivot = $test->users()->withPivot('grade')->get();
        return $studentsWithPivot;
    }
}