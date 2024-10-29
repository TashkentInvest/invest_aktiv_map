<?php

namespace Database\Seeders\init;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name'=> 'Ruxsatnoma',
            'status'=>false
        ]);
        Category::create([
            'name'=> 'Apz',
            'status'=>false
        ]);
        Category::create([
            'name'=> 'Kengash',
            'status'=>false
        ]);
    }
}
