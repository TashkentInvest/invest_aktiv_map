<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
use Spatie\Permission\Models\Permission;

class AddNewUsersController extends Controller
{
    public function importUsers()
    {
        // Ensure 'Employee' role exists
        Role::firstOrCreate(['name' => 'Employee', 'guard_name' => 'web']);

        try {
            // Use public_path() to get the correct path in the public directory
            $filePath = public_path('login_parol27november.xlsx');

            // Check if the file exists
            if (!file_exists($filePath)) {
                return response()->json(['error' => 'File does not exist at the specified path.']);
            }

            // Read the Excel file
            $collection = Excel::toCollection(null, $filePath);

            // Extract the first sheet (assuming the data is on the first sheet)
            $sheet = $collection->first();

            // Loop through the rows and process the data
            foreach ($sheet as $row) {
                // Skip empty rows
                if ($row->isEmpty()) {
                    continue;
                }

                // Assume the first column is email and the second column is password
                $email = $row[0];  // First column: Email
                $password = $row[1]; // Second column: Password

                // Validate the email and password
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    // Check if the user already exists
                    $existingUser = User::where('email', $email)->first();

                    if (!$existingUser) {
                        // Create user if the email does not exist
                        $user = User::create([
                            'name' => 'Employee',
                            'email' => $email,
                            'password' => bcrypt($password), // Encrypt the password
                        ]);

                        // Assign 'Employee' role
                        $user->assignRole('Employee');
                    } else {
                        // Skip if the email already exists
                        continue;
                    }
                } else {
                    // Handle invalid email (logging or skipping)
                    continue;
                }
            }

        } catch (Exception $e) {
            // Handle errors (e.g., file not found or issues reading the file)
            return response()->json(['error' => 'File processing failed: ' . $e->getMessage()]);
        }
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

        // Roles
        Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Employee', 'guard_name' => 'web']);
        // Add other roles as needed
    }
}
