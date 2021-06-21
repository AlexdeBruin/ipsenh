<?php

use App\Specialisation;
use Illuminate\Database\Seeder;

class SpecialisationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Specialisation::firstOrCreate([
            'name' => 'Software Engineering',
            'description' => 'SE'
        ]);

        Specialisation::firstOrCreate([
            'name' => 'Forensisch ICT',
            'description' => 'FICT'
        ]);

        Specialisation::firstOrCreate([
            'name' => 'Interactie Technologie',
            'description' => 'IAT'
        ]);

        Specialisation::firstOrCreate([
            'name' => 'Business Data Management',
            'description' => 'BDAM'
        ]);

        Specialisation::firstOrCreate([
            'name' => 'Algemeen',
            'description' => 'ALG'
        ]);

        // $se->save();
        // $fict->save();
        // $iat->save();
        // $bdam->save();
        // $algemeen->save();
    }
}

