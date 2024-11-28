<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ko;
 
class KoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ko::create(['name' => 'Alohida turgan xususiy ijtimoiy infratuzilma va turizm obyektlari', 'coefficient' => 0.5]);
        Ko::create(['name' => 'Davlat ulushi 50 (ellik) foizdan ortiq bo‘lgan davlat va (yoki) munitsipal mulk negizida amalga oshiriladigan investitsiya loyihalari doirasidagi obyektlar', 'coefficient' => 0.5]);
        Ko::create(['name' => 'Ishlab chiqarish korxonalarining umumiy ovqatlanish joylari, sport-sog‘lomlashtirish zallari (xonalari), ofislar va turar joylarni qurish, renovatsiya va rekonstruksiya qilish uchun', 'coefficient' => 0.5]);
        Ko::create(['name' => 'Omborxonalarni har bir qavati uchun 2 (ikki) metr balandlikdan oshmagan oʻlchamda foydalaniladigan obyektlar', 'coefficient' => 0.5]);
        Ko::create(['name' => 'Mazkur bo‘limning 1–5-qatorlarida ko‘rsatilmagan boshqa obyektlar', 'coefficient' => 1]);
    }
}
