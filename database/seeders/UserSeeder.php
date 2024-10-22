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
        $permissionGroups = [
            'Inventory Management' => [
                'item management',
            ],
            'User Management' => [
                'user management',
                'role management',
            ],
            'File Maintenance' => [
                'brand maintenance',
                'category maintenance',
                'condition maintenance',
                'department maintenance',
                'designation maintenance',
                'status maintenance',
                'subcategory maintenance',
            ],
            'Administrative Permissions' => [
                'audit history',
                'system settings',
                'recycle bin'
            ],
        ];

        $actions = ['view', 'create', 'update', 'delete'];

        foreach ($permissionGroups as $group => $basePermissions) {
            foreach ($basePermissions as $base) {
                foreach ($actions as $action) {
                    if (($group === 'Administrative Permissions') && !in_array($action, ['view', 'update'])) {
                        continue;
                    }

                    if ($group === 'audit history' && $action !== 'view') {
                        continue;
                    }

                    Permission::query()->create([
                        'name' => "$action $base",
                        'group_name' => $group,
                    ]);
                }
            }
        }


        $roles = [
            'Administrator' => 'Oversees the system with full access to all settings.',
            'Property Custodian' => 'Manages and maintains all property and equipment.',
            'Student Assistant' => 'Aids the Property Custodian in daily asset management.',
        ];

        foreach ($roles as $role => $description) {
            Role::query()->create([
                'name' => $role,
                'description' => $description,
            ]);
        }

        $roles = Role::all();
        $permissions = Permission::all();

        $rolePermissionMap = [
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
                    RolePermission::query()->insert([
                        'role_id' => $role->id,
                        'perm_id' => $permission->id,
                    ]);
                }
            }
        }


        $users = [
            [
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
            ],
            [
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
            ],
            [
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
            ]
        ];

        foreach ($users as $data) {
            User::create([
                'user_name' => $data['user_name'],
                'pass_hash' => $data['pass_hash'],
                'fname' => $data['fname'],
                'mname' => $data['mname'],
                'lname' => $data['lname'],
                'role_id' => $data['role_id'],
                'dept_id' => $data['dept_id'],
                'email' => $data['email'],
                'phone_num' => $data['phone_num'],
                'user_image' => $data['user_image'],
                'is_active' => $data['is_active'],
            ]);
        }
    }
}
