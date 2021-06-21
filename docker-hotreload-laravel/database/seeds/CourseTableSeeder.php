<?php

use App\Course;
use App\Specialisation;
use Illuminate\Database\Seeder;

class CourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id_spec_se = Specialisation::where('description', 'SE')->first()->id;
        $id_spec_bdam = Specialisation::where('description', 'BDAM')->first()->id;
        $id_spec_iat = Specialisation::where('description', 'IAT')->first()->id;
        $id_spec_fict = Specialisation::where('description', 'FICT')->first()->id;
        $id_spec_alg = Specialisation::where('description', 'ALG')->first()->id;

        $iad = Course::firstOrNew([
            'course_code' => 'IAD',
            'spec_id' => $id_spec_se,
            'course_description' => 'Algoritme en datastructuren',
            'semester' => [3],
            'year' => 3,
            'ec' => 3
        ]);

        $iitorg = Course::firstOrNew([
            'course_code' => 'IITORG',
            'spec_id' => $id_spec_alg,
            'course_description' => 'IT organisaties',
            'semester' => [3],
            'year' => 3,
            'ec' => 3
        ]);

        $idaan = Course::firstOrNew([
            'course_code' => 'IDAAN',
            'spec_id' => $id_spec_bdam,
            'course_description' => 'IT Data',
            'semester' => [2],
            'year' => 3,
            'ec' => 3
        ]);

        $iad->save();
        $iitorg->save();
        $idaan->save();
    }
}
