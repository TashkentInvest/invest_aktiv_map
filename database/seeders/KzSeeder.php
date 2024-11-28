<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kz; 


class KzSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kz::create(['name' => '1-zona', 'coefficient' => 1.40]);
        Kz::create(['name' => '2-zona', 'coefficient' => 1.25]);
        Kz::create(['name' => '3-zona', 'coefficient' => 1]);
        Kz::create(['name' => '4-zona', 'coefficient' => 0.75]);
        Kz::create(['name' => '5-zona', 'coefficient' => 0.50]);
    }
}
