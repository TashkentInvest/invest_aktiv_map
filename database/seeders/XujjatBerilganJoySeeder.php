<?php

namespace Database\Seeders;

use App\Models\XujjatBerilganJoyi;
use Illuminate\Database\Seeder;

class XujjatBerilganJoySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $districts = [
            ['name' => 'Yunusabad IIB', 'comment' => ''],
            ['name' => 'Chilanzar IIB', 'comment' => ''],
            ['name' => 'Shayhontohur IIB', 'comment' => ''],
            ['name' => 'Mirzo Ulughbek IIB', 'comment' => ''],
            ['name' => 'Yakkasaray IIB', 'comment' => ''],
            ['name' => 'Mirobod IIB', 'comment' => ''],
            ['name' => 'Sergeli IIB', 'comment' => ''],
            ['name' => 'Bektemir IIB', 'comment' => ''],
            ['name' => 'Uchtepa IIB', 'comment' => ''],
            ['name' => 'Hamza IIB', 'comment' => ''],
            ['name' => 'Almazar IIB', 'comment' => ''],
            ['name' => 'Olmazor IIB', 'comment' => ''],
        ];
        
        // Create each IIB
        foreach ($districts as $district) {
            XujjatBerilganJoyi::create($district);
        }
        
    }
}
