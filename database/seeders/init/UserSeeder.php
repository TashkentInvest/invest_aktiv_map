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
     */
    public function run()
    {
        // Existing code to create initial users and roles
        $superuser = User::create([
            "name" => "Super Admin",
            "email" => "superadmin@example.com",
            "password" => bcrypt("teamdevs")
        ]);

        $this->createPermissionsAndRoles();

        $superuser->assignRole('Super Admin');
        $permissions = Permission::all();
        $superuser->syncPermissions($permissions);

        // Ensure 'Employee' role exists
        Role::firstOrCreate(['name' => 'Employee', 'guard_name' => 'web']);

        // Define the list of emails and passwords
        $userList = <<<EOL
Email	Password
100@gmail.com	a151ac93f4
101@gmail.com	91837d8f49
102@gmail.com	db6f7f4b8a
103@gmail.com	6850e1c178
104@gmail.com	79fd425532
105@gmail.com	46d6a3374b
106@gmail.com	7fa1a8a34e
107@gmail.com	202d21fca7
108@gmail.com	0c17bc3fff
109@gmail.com	c0ae09c6c1
110@gmail.com	cc3a56fe25
111@gmail.com	03d0294d3e
112@gmail.com	f3e3757627
113@gmail.com	7b6a0b4045
114@gmail.com	2f711f69e3
115@gmail.com	6b8e75f88c
116@gmail.com	301897d3fb
117@gmail.com	1ad977120b
118@gmail.com	051988bf50
119@gmail.com	5387f98b07
120@gmail.com	fcb50432ca
121@gmail.com	aaddd9c469
122@gmail.com	9cd06ad240
123@gmail.com	c3059de861
124@gmail.com	cff65c09e9
125@gmail.com	b1e3ad07c7
126@gmail.com	3e5241ecc7
127@gmail.com	880e3b0daf
128@gmail.com	04878332cc
129@gmail.com	f5388adddb
130@gmail.com	2099e7c5c9
131@gmail.com	a7382acc85
132@gmail.com	c910877377
133@gmail.com	d4187e8f0c
134@gmail.com	ef4aaa96cb
135@gmail.com	1fbc844548
136@gmail.com	962b4157bd
137@gmail.com	26e2011626
138@gmail.com	c30ab8ce68
139@gmail.com	7db559f53e
140@gmail.com	be4c7695ca
141@gmail.com	76c63395ea
142@gmail.com	1c333fe01d
143@gmail.com	7219ea61b5
144@gmail.com	0282184364
145@gmail.com	b596e81963
146@gmail.com	50e5e8c12a
147@gmail.com	94345ee3d2
148@gmail.com	f91a1448e5
149@gmail.com	b88142b519
150@gmail.com	d6ffedf81a
151@gmail.com	6a8ce6ca7d
152@gmail.com	2e52640020
153@gmail.com	33ec676427
154@gmail.com	e7ad657db9
155@gmail.com	0dcb6bad14
156@gmail.com	e142c8aa90
157@gmail.com	4692804456
158@gmail.com	b4c68b667f
159@gmail.com	1ba39f0d27
160@gmail.com	85792c36a2
161@gmail.com	f26d1e63f0
162@gmail.com	dd943ec1d8
163@gmail.com	200889352e
164@gmail.com	f67f570397
165@gmail.com	a7b7f6bdfc
166@gmail.com	137752d3b5
167@gmail.com	f8e2e01cf4
168@gmail.com	7cfff0e935
169@gmail.com	ce2ff89e41
170@gmail.com	d4ed09ac73
171@gmail.com	f1c0150f80
172@gmail.com	162612ede5
173@gmail.com	9e05452f38
174@gmail.com	d51ee6768f
175@gmail.com	7471b0f734
176@gmail.com	aef698ba32
177@gmail.com	daa9aed399
178@gmail.com	72c57ffbee
179@gmail.com	82d986ad15
180@gmail.com	74624c9e29
181@gmail.com	65d2f0c077
182@gmail.com	220f438455
183@gmail.com	7f1882f0e1
184@gmail.com	bcea5cea12
185@gmail.com	2a8c61e5e3
186@gmail.com	8ee6f5ae09
187@gmail.com	8c47c944a8
188@gmail.com	4d61bd654c
189@gmail.com	4f20811a3f
190@gmail.com	d2f43ce5d4
191@gmail.com	d9f0bbb7c6
192@gmail.com	1d37ff0909
193@gmail.com	090fc68e2c
194@gmail.com	c7c4750e35
195@gmail.com	ff0f8c84a4
196@gmail.com	cf219bdc5d
197@gmail.com	7031530683
198@gmail.com	c531d27bb1
199@gmail.com	f8bd03ea96
EOL;

        // Parse the list into an array
        $lines = explode("\n", $userList);
        // Remove the header line
        array_shift($lines); // Remove "Email\tPassword"

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            // Split by whitespace or tab
            list($email, $password) = preg_split('/\s+/', $line);

            // Create user
            $user = User::create([
                'name' => 'Employee',
                'email' => $email,
                'password' => bcrypt($password)
            ]);

            // Assign 'Employee' role
            $user->assignRole('Employee');
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
