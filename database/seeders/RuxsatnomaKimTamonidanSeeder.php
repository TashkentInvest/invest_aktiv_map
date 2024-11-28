<?php

namespace Database\Seeders;

use App\Models\RuxsatnomaKimTamonidan;
use Illuminate\Database\Seeder;

class RuxsatnomaKimTamonidanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RuxsatnomaKimTamonidan::create(['name' => 'Toshkent shahar qurilish bosh boshqarmasi', 'comment' => '']);
        RuxsatnomaKimTamonidan::create(['name' => 'Toshkent shahar Hokimi', 'comment' => '']);
        RuxsatnomaKimTamonidan::create(['name' => 'Vazirlar mahkamasi', 'comment' => '']);
        RuxsatnomaKimTamonidan::create(['name' => 'Prezident', 'comment' => '']);
    }
}
