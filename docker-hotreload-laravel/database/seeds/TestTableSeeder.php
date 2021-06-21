<?php

use App\Course;
use App\Specialisation;
use App\Test;
use App\User;
use Illuminate\Database\Seeder;

class TestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $selectedStudent = User::where('first_name', 'Student Voornaam') -> first();

        $students = User::whereHas('roles', function($query) {
            $query->where('name', '=', 'student');
        })->take(3)->get();

        factory(Test::class, 10)->create()->each(function($test) use ($students, $selectedStudent) {
            $test->users()->attach($students);
            $test->users()->attach($selectedStudent);
        });
    }
}
