<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kj; 

class KjSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kj::create(['name' => 'Metro bekatidan chiqish joyidan obyekt chegarasigacha 200 metr radius oralig‘i hududlardan boshqa hududlarda joylashgan loyihaviy binolar (inshootlar)', 'coefficient' => 0.6]);
        Kj::create(['name' => 'Mazkur bo‘limning 1-qatorida ko‘rsatilmagan boshqa obyektlar', 'coefficient' => 1]);
    }
}
