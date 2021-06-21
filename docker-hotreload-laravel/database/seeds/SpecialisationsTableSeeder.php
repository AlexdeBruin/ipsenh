<?php

use Illuminate\Database\Seeder;
use App\Specialisation;

class SpecialisationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Specialisation::firstOrCreate([
            'name' => 'propedeuse',
            'description' => 'Eerste jaar van school, voor het kiezen van een specialisatie.'
        ]);

        Specialisation::firstOrCreate([
            'name' => 'Software Engineer',
            'description' => 'Leren designen en ontwikkelen van systemen.'
        ]);

        Specialisation::firstOrCreate([
            'name' => 'Business Data Managment',
            'description' => 'Data ophalen, opslaan en analyseren.'
        ]);

        Specialisation::firstOrCreate([
            'name' => 'Interactie Technologie',
            'description' => 'Voornamelijk web technologieen'
        ]);

        Specialisation::firstOrCreate([
            'name' => 'Forensisch ICT',
            'description' => 'Andere kijk op ICT'
        ]);
    }
}
