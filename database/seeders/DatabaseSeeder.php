<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            SystemInitSeeder::class,
            StreetsTableSeeder::class,
            SubStreetSeeder::class,
            SubyektShakliSeeder::class,
            OrderAtkazSeeder::class,
            RuxsatnomaKimTamonidanSeeder::class,
            RuxsatnomaBerilganIshTuriSeeder::class,
            RuxsatnomaTuriSeeder::class,
            BankSeeder::class,
            XujjatTuriSeeder::class,
            XujjatBerilganJoySeeder::class,
            KjSeeder::class,
            KoSeeder::class,
            KtSeeder::class,
            KzSeeder::class,
            // ExcelToDatabaseSeeder::class,
            // ClientDataSeeder::class,

        ]);
    }
}
