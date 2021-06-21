<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate([
            'name' => 'student',
            'description' => 'Users that should only be allowed to do things that students could do.'
        ]);
        Role::firstOrCreate([
            'name' => 'teacher',
            'description' => 'Users that are allowed to gives grades to students.'
        ]);
        Role::firstOrCreate([
            'name' => 'admin',
            'description' => 'The users that are allowed to edit/add users.'
        ]);
        Role::firstOrCreate([
            'name' => 'teacher',
            'description' => 'The users that are allowed to manage courses.'
        ]);
    }
}
