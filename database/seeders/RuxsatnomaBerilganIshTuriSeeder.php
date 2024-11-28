<?php

namespace Database\Seeders;

use App\Models\RuxsatnomaBerilganIshTuri;
use Illuminate\Database\Seeder;

class RuxsatnomaBerilganIshTuriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RuxsatnomaBerilganIshTuri::create(['name' => 'Ko\'p qavatli turar joy', 'comment' => '']);
        RuxsatnomaBerilganIshTuri::create(['name' => 'Savdo maishiy xizmat ko\'rsatish majmuasi', 'comment' => '']);
        RuxsatnomaBerilganIshTuri::create(['name' => 'Biznes markaz', 'comment' => '']);
        RuxsatnomaBerilganIshTuri::create(['name' => 'Ofis', 'comment' => '']);
        RuxsatnomaBerilganIshTuri::create(['name' => 'Ishlab chiqarish', 'comment' => '']);
        RuxsatnomaBerilganIshTuri::create(['name' => 'Omborxona', 'comment' => '']);
        RuxsatnomaBerilganIshTuri::create(['name' => 'Avtoturargoh', 'comment' => '']);

      
    }
}
