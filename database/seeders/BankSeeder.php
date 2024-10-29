<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bank::create([
            'name' => 'Agro Bank',
            'code'  => '01140',
            'comment' => 'agro bank test comment',
            // 'street_id' => 1 ?? null,
        ]);

        Bank::create([
            'name' => 'Xamkor Bank',
            'code'  => '00443',
            'comment' => 'xamkor akb bank',
            // 'street_id' => 1 ?? null,
        ]);
    }
}
