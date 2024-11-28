<?php

namespace Database\Seeders\init;

use Illuminate\Database\Seeder;
use App\Models\Regions;

class RegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regionsArray = json_decode(file_get_contents(__DIR__."/../references/regions.json"));
        echo "Regions::inserting".PHP_EOL;
		foreach($regionsArray as $regionObject)
		{
            $region = new Regions();
            $region->name_uz = $regionObject->name_uz;
            $region->name_ru = $regionObject->name_ru;
            $region->static_id = $regionObject->id;
            $region->save();
		}
    }
}
