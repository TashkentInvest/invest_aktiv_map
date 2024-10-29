<?php

namespace Database\Seeders;

use App\Models\RuxsatnomaTuri;
use Illuminate\Database\Seeder;

class RuxsatnomaTuriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RuxsatnomaTuri::create(['name' => 'Qayta qurish', 'comment' => '']);
        RuxsatnomaTuri::create(['name' => 'Rekonstruksiya', 'comment' => '']);
        RuxsatnomaTuri::create(['name' => 'O\'z hududida qo\'shimcha bino inshoot qurish', 'comment' => '']);
    }
}
