<?php

namespace Database\Seeders;

use App\Models\Permission;
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
        $groups = [
            'Property & Asset Management' => [
                'item management',
            ],
            'User Management' => [
                'user management',
                'role management',
            ],
            'File Maintenance' => [
                'brand maintenance',
                'category maintenance',
                'department maintenance',
                'designation maintenance',
            ],
            'Administrative Permissions' => [
                'audit history',
                'system settings',
            ],
        ];

        $actions = ['view', 'create', 'update', 'delete'];

        foreach ($groups as $group => $basePermissions) {
            foreach ($basePermissions as $base) {
                foreach ($actions as $action) {
                    if ($group === 'Administrative Permissions' && !in_array($action, ['view', 'update'])) {
                        continue;
                    }

                    if ($group === 'audit history' && $action !== 'view') {
                        continue;
                    }

                    Permission::create([
                        'name' => "$action $base",
                        'group' => $group,
                    ]);
                }
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

        $roles = Role::all();
        $permissions = Permission::all();

        $rolePermissionMap = [
            'Super Admin' => $permissions,
            'Administrator' => $permissions,
            'Property Custodian' => $permissions->filter(function ($permission) {
                return !str_contains($permission->name, 'delete') &&
                    !str_contains($permission->name, 'user management') &&
                    !str_contains($permission->name, 'role management');
            }),
            'Student Assistant' => $permissions->filter(function ($permission) {
                return (str_contains($permission->name, 'item management') ||
                        str_contains($permission->name, 'maintenance')) &&
                    (str_contains($permission->name, 'view') ||
                        str_contains($permission->name, 'create') ||
                        str_contains($permission->name, 'update'));
            }),
        ];

        foreach ($roles as $role) {
            $roleName = $role->name;
            if (isset($rolePermissionMap[$roleName])) {
                foreach ($rolePermissionMap[$roleName] as $permission) {
                    RolePermission::insert([
                        'role_id' => $role->id,
                        'perm_id' => $permission->id,
                    ]);
                }
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
