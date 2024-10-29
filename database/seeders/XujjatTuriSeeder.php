<?php

namespace Database\Seeders;

use App\Models\XujjatTuri;
use Illuminate\Database\Seeder;

class XujjatTuriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            XujjatTuri::create(['name' => 'Passport', 'comment' => '']);
            XujjatTuri::create(['name' => 'ID Karta', 'comment' => '']);

    }
}
