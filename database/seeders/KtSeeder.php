<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kt; 

class KtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kt::create(['name' => 'Yangi kapital qurilish', 'coefficient' => 1]);
        Kt::create(['name' => 'Obyektni rekonstruksiya qilish', 'coefficient' => 1]);
        Kt::create(['name' => 'O‘zbekiston Respublikasi Shaharsozlik kodeksiga muvofiq loyiha-smeta hujjatlari ekpertizasi talab etilmaydigan obyektlarini rekonstruksiya qilish', 'coefficient' => 0]);
        Kt::create(['name' => 'Obyektni qurilish hajmini o‘zgartirmagan holda rekonstruksiya qilish', 'coefficient' => 0]);
    }
}
