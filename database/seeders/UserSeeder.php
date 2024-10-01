<?php

namespace Database\Seeders;

use App\Models\Permission;
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
        $permissions = [
            'view file-maintenance',
            'create file-maintenance',
            'edit file-maintenance',
            'delete file-maintenance',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $roles = [
            'Administrator',
            'Property Custodian',
            'Student Assistant',
        ];

        foreach ($roles as $role) {
            $roleInstance = Role::create(['name' => $role]);

            if ($role === 'Administrator') {
                $roleInstance->givePermissionTo($permissions);
            }
        }

        $users = [
            [
                'user_name' => '21-00017',
                'pass_hash' => bcrypt('JtAchondo05!'),
                'fname' => 'Joshua Trazen',
                'mname' => 'Delos Santos',
                'lname' => 'Achondo',
                'role' => 'Administrator',
                'dept_id' => 2,
                'email' => 'dev.jt1005@gmail.com',
                'phone_num' => '0934-221-6405',
                'user_image' => 'jt.jpg',
                'is_active' => 1
            ],
            [
                'user_name' => '21-00155',
                'pass_hash' => bcrypt('RobBunag22!'),
                'fname' => 'Rob Meynard',
                'mname' => 'Pumento',
                'lname' => 'Bunag',
                'role' => 'Property Custodian',
                'dept_id' => 2,
                'email' => 'rm.bunag2202@gmail.com',
                'phone_num' => '0916-437-4284',
                'user_image' => 'rob.jpg',
                'is_active' => 1
            ],
            [
                'user_name' => '21-00132',
                'pass_hash' => bcrypt('KjQuimora24!'),
                'fname' => 'Khervin John',
                'mname' => 'Pastoral',
                'lname' => 'Quimora',
                'role' => 'Administrator',
                'dept_id' => 2,
                'email' => 'khervinjohnquimora@gmail.com',
                'phone_num' => '0976-216-2403',
                'user_image' => 'kj.jpg',
                'is_active' => 1
            ]
        ];

        foreach ($users as $data) {
            $user = User::create([
                'user_name' => $data['user_name'],
                'pass_hash' => $data['pass_hash'],
                'fname' => $data['fname'],
                'mname' => $data['mname'],
                'lname' => $data['lname'],
                'dept_id' => $data['dept_id'],
                'email' => $data['email'],
                'phone_num' => $data['phone_num'],
                'user_image' => $data['user_image'],
                'is_active' => $data['is_active'],
            ]);
            $user->syncRoles($data['role']);
        }
    }
}
