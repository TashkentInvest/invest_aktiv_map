<?php

namespace Database\Seeders\init;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superuser = User::create([
            "name" => "Super Admin",
            "email" => "superadmin@example.com",
            "password" => bcrypt("teamdevs")
        ]);

        $this->createPermissionsAndRoles();

        $superuser->assignRole('Super Admin');
        $permissions = Permission::all();
        $superuser->syncPermissions($permissions);

        // admin user

        $adminuser = User::create([
            "name" => "Admin",
            "email" => "admin@gmail.com",
            "password" => bcrypt("password")
        ]);

        $this->createPermissionsAndRoles();

        $adminuser->assignRole('Admin');
        $permissions = Permission::all();
        $adminuser->syncPermissions($permissions);

        $manager = User::create([
            "name" => "jakhongir",
            "email" => "jakhongir.uljabaev@gmail.com",
            "password" => bcrypt("1100511#")
        ]);


        $this->createPermissionsAndRoles();

        $manager->assignRole('Manager');
        $permissions = Permission::all();
        $manager->syncPermissions($permissions);

        $employeer1 = User::create([
            "name" => "Sirojiddin",
            "email" => "s.qobulov@tashkentinvest.com",
            "password" => bcrypt("87654321aA")
        ]);


        $this->createPermissionsAndRoles();

        $employeer1->assignRole('Employee');
        $permissions = Permission::all();
        $employeer1->syncPermissions($permissions);
    }

    /**
     * Create permissions and roles if they do not exist.
     */
    private function createPermissionsAndRoles()
    {
        // Permissions
        $permissions = [
        "permission.show", "permission.edit", "permission.add", "permission.delete",
        "roles.show", "roles.edit", "roles.add", "roles.delete"
    ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Role
        Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
    }
}
