<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(SpecialisationTableSeeder::class);
        $this->call(CourseTableSeeder::class);
        
        $this->call(UserTableSeeder::class);
        $this->call(TestTableSeeder::class);
        $this->call(AnnouncementTableSeeder::class);
    }
}
