<?php

use App\Role;
use App\User;
use App\Course;
use App\Specialisation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_student  = Role::where('name', 'student')->first();
        $role_admin    = Role::where('name', 'admin')->first();
        $role_teacher  = Role::where('name', 'teacher')->first(); 
        $courses       = Course::all();


        factory(User::class, 10)->create()->each(function ($user) use($role_admin) {
            $user->roles()->sync($role_admin);
        });

        factory(User::class, 50)->create()->each(function ($user) use($role_student) {
            $user->roles()->sync($role_student);
        });

        factory(User::class, 20)->create()->each(function ($user) use($role_teacher) {
            $user->roles()->sync($role_teacher);
        });

        $admin = User::firstOrNew([
            'first_name' => 'Admin Voornaam',
            'last_name' => 'Admin Achternaam',
            'email' => 'admin@admin.com',
            'birthdate' => '1996-03-21',
            'address' => 'brakenburghstraat 47',
            'zip_code' => '2023DT'
        ]);
        $admin->password = hash::make('admin');
        $admin->save();
        $admin->roles()->sync($role_admin);

        $student = User::firstOrNew([
            'first_name' => 'Student Voornaam',
            'last_name' => 'Student Achternaam',
            'email' => 'student@student.com',
            'birthdate' => '1996-03-21',
            'address' => 'brakenburghstraat 47',
            'zip_code' => '2023DT'
        ]);
        $student->password = hash::make('student');
        $student->save();
        foreach($courses as $course)
        {
            $course->users()->attach($student->id, [
                'role' => 'COURSE_STUDENT',
                'showing' => 1
            ]);
        }
        $student->roles()->sync($role_student);

        $teacher = User::firstOrNew([
            'first_name' => 'Docent Voornaam',
            'last_name' => 'Docent Achternaam',
            'email' => 'docent@docent.com',
            'birthdate' => '1996-03-21',
            'address' => 'brakenburghstraat 47',
            'zip_code' => '2023DT'
        ]);

        $teacher->password = hash::make('docent');
        $teacher->save();
        foreach($courses as $course)
        {
            $course->users()->attach($teacher->id, [
                'role' => 'COURSE_TEACHER',
                'showing' => 1
            ]);
        }
        $teacher->roles()->sync($role_teacher);
    }
}
