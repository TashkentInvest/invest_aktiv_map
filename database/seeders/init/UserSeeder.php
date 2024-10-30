<?php

namespace Database\Seeders\init;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usersData = [];
        $this->createPermissionsAndRoles();

        // Generate 100 unique users
        for ($i = 100; $i < 200; $i++) {
            $email = "{$i}@gmail.com";
            $password = $this->generateUniquePassword();

            // Create user and assign 'Employee' role
            $user = User::create([
                "name" => "User {$i}",
                "email" => $email,
                "password" => bcrypt($password)
            ])->assignRole('Employee');

            $usersData[] = ['Email' => $email, 'Password' => $password];
        }

        // Export to Excel
        $this->exportToExcel($usersData);
    }

    /**
     * Create permissions and roles if they do not exist.
     */
    private function createPermissionsAndRoles()
    {
        $permissions = [
            "permission.show", "permission.edit", "permission.add", "permission.delete",
            "roles.show", "roles.edit", "roles.add", "roles.delete"
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        Role::firstOrCreate(['name' => 'Employee', 'guard_name' => 'web']);
    }

    /**
     * Generate a unique password
     *
     * @return string
     */
    private function generateUniquePassword()
    {
        return bin2hex(random_bytes(5)); // Generates a 10-character password
    }

    /**
     * Export data to an Excel file
     *
     * @param array $data
     * @return void
     */
    private function exportToExcel(array $data)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Email');
        $sheet->setCellValue('B1', 'Password');

        // Populate the data
        $row = 2;
        foreach ($data as $user) {
            $sheet->setCellValue("A{$row}", $user['Email']);
            $sheet->setCellValue("B{$row}", $user['Password']);
            $row++;
        }

        // Save the file
        $filePath = storage_path('app/public/gmail_accounts.xlsx');
        (new Xlsx($spreadsheet))->save($filePath);
        $this->command->info("Excel file saved to {$filePath}");
    }
}
