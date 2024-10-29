<?php

namespace Database\Seeders;

use App\Models\OrderAtkaz;
use Illuminate\Database\Seeder;

class OrderAtkazSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderAtkaz::create([
            'name' => 'Noqonuniy',
            'name_ru' => 'Noqonuniy ruk',
            'comment' => 'shu sababga kora atmen boldi',
            'status' => 1,
        ]);

        OrderAtkaz::create([
            'name' => 'Xato qurilgan',
            'name_ru' => 'Xato qurilgan ru',
            'comment' => 'shu sababga kora atmen boldi',
            'status' => 1,
        ]);
    }
}
