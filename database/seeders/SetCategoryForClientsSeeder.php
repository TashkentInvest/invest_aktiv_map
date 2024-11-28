<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SetCategoryForClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('clients')->update(['category_id' => 2]);

    }
}
