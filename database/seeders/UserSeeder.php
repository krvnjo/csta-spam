<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Administrator',
            'Property Custodian',
            'Student Assistant',
            'Department Custodian',
            'Technician'
        ];

        foreach ($roles as $role) {
            Role::query()->create([
                'name' => $role
            ]);
        }

        User::query()->create([
            'user_name' => '21-00017',
            'pass_hash' => bcrypt('JtAchondo05!'),
            'fname' => 'Joshua Trazen',
            'mname' => 'Delos Santos',
            'lname' => 'Achondo',
            'role_id' => 1,
            'dept_id' => 2,
            'email' => 'dev.jt1005@gmail.com',
            'phone_num' => '0934-221-6405',
            'user_image' => 'jt.jpg',
            'is_active' => 1
        ]);

        User::query()->create([
            'user_name' => '21-00155',
            'pass_hash' => bcrypt('RobBunag22!'),
            'fname' => 'Rob Meynard',
            'mname' => 'Pumento',
            'lname' => 'Bunag',
            'role_id' => 1,
            'dept_id' => 2,
            'email' => 'rm.bunag2202@gmail.com',
            'phone_num' => '0916-437-4284',
            'user_image' => 'rob.jpg',
            'is_active' => 1
        ]);

        User::query()->create([
            'user_name' => '21-00132',
            'pass_hash' => bcrypt('KjQuimora24!'),
            'fname' => 'Khervin John',
            'mname' => 'Pastoral',
            'lname' => 'Quimora',
            'role_id' => 1,
            'dept_id' => 2,
            'email' => 'khervinjohnquimora@gmail.com',
            'phone_num' => '0976-216-2403',
            'user_image' => 'kj.jpg',
            'is_active' => 1
        ]);
    }
}
