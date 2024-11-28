<?php

namespace Database\Seeders\init;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RoleGroup;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rolesJson = json_decode( file_get_contents(__DIR__."/../references/roles.json") );
        echo "ROLES::inserting".PHP_EOL;
		foreach($rolesJson as $item)
		{
			$role = new RoleGroup();
            $role->name = $item->name;
            $role->guard_name = $item->guard_name;
            $role->title = $item->title;
			$role->save();
		}
    }
}
