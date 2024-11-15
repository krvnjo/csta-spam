<?php

namespace Database\Seeders;

use App\Models\Access;
use App\Models\Permission;
use App\Models\Requester;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $requesters = [
            [
                'req_num' => '21-00090',
                'name' => 'Joshua M. Maglinao',
                'lname' => 'Maglinao',
                'fname' => 'Joshua',
                'mname' => 'Martin',
                'dept_id' => 2,
                'email' => 'joshuamaglinao@gmail.com',
                'phone_num' => '0979-345-1234',
            ],
            [
                'req_num' => '21-00075',
                'name' => 'Mark Jason A. Espinosa',
                'lname' => 'Espinosa',
                'fname' => 'Mark Jason',
                'mname' => 'Aranez',
                'dept_id' => 2,
                'email' => 'markjasonespinosa@gmail.com',
                'phone_num' => '0934-474-8693',
            ],
            [
                'req_num' => '21-00313',
                'name' => 'Johnsen S. Lopez',
                'lname' => 'Lopez',
                'fname' => 'Johnsen',
                'mname' => 'Santos',
                'dept_id' => 2,
                'email' => 'johnsenlopez@gmail.com',
                'phone_num' => '0974-9314-4567',
            ],
            [
                'req_num' => '21-00614',
                'name' => 'Froilan V. Odog',
                'lname' => 'Odog',
                'fname' => 'Froilan',
                'mname' => 'Villanueva',
                'dept_id' => 2,
                'email' => 'froilanodog@gmail.com',
                'phone_num' => '0953-785-2345',
            ],
        ];

        foreach ($requesters as $data) {
            Requester::create([
                'req_num' => $data['req_num'],
                'name' => $data['name'],
                'lname' => $data['lname'],
                'fname' => $data['fname'],
                'mname' => $data['mname'],
                'dept_id' => $data['dept_id'],
                'email' => $data['email'],
                'phone_num' => $data['phone_num'],
            ]);
        }

        $accesses = [
            'View Only' => 'View content only, no changes allowed.',
            'Read and Write' => 'Can view, add, and edit content as needed.',
            'Full Access' => 'Has full control over all features, including deletion.',
        ];

        foreach ($accesses as $access => $description) {
            Access::create([
                'name' => $access,
                'description' => $description,
            ]);
        }

        $groups = [
            'Property & Asset Management' => [
                'Item Management',
                'Borrow & Reservation',
                'Repair & Maintenance',
                'Analytics Reports',
            ],
            'Administrative Permissions' => [
                'User Management',
                'File Maintenance',
                'Audit History',
            ],
        ];

        foreach ($groups as $group => $permissions) {
            foreach ($permissions as $permission) {
                Permission::create([
                    'name' => $permission,
                    'group' => $group,
                ]);
            }
        }

        $roles = [
            'Super Admin' => [
                'description' => 'Full control over all of the system features.',
                'dashboard' => 1,
            ],
            'Administrator' => [
                'description' => 'Oversees and manage the system with all access to the system.',
                'dashboard' => 1,
            ],
            'Property Custodian' => [
                'description' => 'Manages and maintains all property and equipment.',
                'dashboard' => 2,
            ],
            'Student Assistant' => [
                'description' => 'Aids the Property Custodian in daily asset management.',
                'dashboard' => 2,
            ],
        ];

        foreach ($roles as $role => $data) {
            Role::create([
                'name' => $role,
                'description' => $data['description'],
                'dash_id' => $data['dashboard'],
            ]);
        }

        $rolesWithPermissions = [
            'Super Admin' => [
                'permissions' => Permission::all()->pluck('name')->toArray(),
                'access' => 'Full Access',
            ],
            'Administrator' => [
                'permissions' => Permission::all()->pluck('name')->toArray(),
                'access' => 'Full Access',
            ],
            'Property Custodian' => [
                'permissions' => ['Item Management', 'Borrow & Reservation', 'Repair & Maintenance', 'File Maintenance', 'Audit History'],
                'access' => 'Full Access',
            ],
            'Student Assistant' => [
                'permissions' => ['Item Management', 'File Maintenance'],
                'access' => 'Read and Write',
            ],
        ];

        $accessLevels = Access::all()->keyBy('name');

        foreach ($rolesWithPermissions as $roleName => $data) {
            $role = Role::where('name', $roleName)->first();
            $accessLevel = $accessLevels[$data['access']];

            foreach ($data['permissions'] as $permissionName) {
                $permission = Permission::where('name', $permissionName)->first();
                RolePermission::insert([
                    'role_id' => $role->id,
                    'perm_id' => $permission->id,
                    'access_id' => $accessLevel->id,
                ]);
            }
        }

        $users = [
            [
                'user_name' => '07-00001',
                'pass_hash' => bcrypt('Cstaspam24!'),
                'name' => 'CSTA-SPAM System',
                'fname' => 'CSTA',
                'mname' => 'SPAM',
                'lname' => 'System',
                'role_id' => 1,
                'dept_id' => 1,
                'email' => 'cstaspam@gmail.com',
                'phone_num' => '0912-345-1234',
                'user_image' => 'system.jpg',
            ],
            [
                'user_name' => '21-00017',
                'pass_hash' => bcrypt('JtAchondo05!'),
                'name' => 'Joshua Trazen Achondo',
                'fname' => 'Joshua Trazen',
                'mname' => 'Delos Santos',
                'lname' => 'Achondo',
                'role_id' => 2,
                'dept_id' => 2,
                'email' => 'dev.jt1005@gmail.com',
                'phone_num' => '0934-221-6405',
                'user_image' => 'jt.jpg',
            ],
            [
                'user_name' => '21-00155',
                'pass_hash' => bcrypt('RobBunag22!'),
                'name' => 'Rob Meynard Bunag',
                'fname' => 'Rob Meynard',
                'mname' => 'Pumento',
                'lname' => 'Bunag',
                'role_id' => 2,
                'dept_id' => 2,
                'email' => 'rm.bunag2202@gmail.com',
                'phone_num' => '0916-437-4284',
                'user_image' => 'rob.jpg',
            ],
            [
                'user_name' => '21-00132',
                'pass_hash' => bcrypt('KjQuimora24!'),
                'name' => 'Khervin John Quimora',
                'fname' => 'Khervin John',
                'mname' => 'Pastoral',
                'lname' => 'Quimora',
                'role_id' => 2,
                'dept_id' => 2,
                'email' => 'khervinjohnquimora@gmail.com',
                'phone_num' => '0976-216-2403',
                'user_image' => 'kj.jpg',
            ],
        ];

        foreach ($users as $data) {
            User::create([
                'user_name' => $data['user_name'],
                'pass_hash' => $data['pass_hash'],
                'name' => $data['name'],
                'fname' => $data['fname'],
                'mname' => $data['mname'],
                'lname' => $data['lname'],
                'role_id' => $data['role_id'],
                'dept_id' => $data['dept_id'],
                'email' => $data['email'],
                'phone_num' => $data['phone_num'],
                'user_image' => $data['user_image'],
            ]);
        }
    }
}
