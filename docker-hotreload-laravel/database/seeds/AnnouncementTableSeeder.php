<?php

use Illuminate\Database\Seeder;
use App\Course;
use App\Announcement;

class AnnouncementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course::all()->each(function($course){
            $course->announcements()->saveMany(factory(Announcement::class, 10)->make());
        });
    }
}
