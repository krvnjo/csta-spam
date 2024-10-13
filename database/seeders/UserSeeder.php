<?php

namespace Database\Seeders;

use App\Models\AuditHistory;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'Inventory Management',
            'User Management',
            'Role Management',
            'Brand Maintenance',
            'Category Maintenance',
            'Condition Maintenance',
            'Department Maintenance',
            'Designation Maintenance',
            'Status Maintenance',
            'Subcategories Maintenance',
            'Audit History',
            'System Settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $roles = [
            'Administrator' => 'Responsible for overseeing the entire system, with full access to all settings and controls.',
            'Property Custodian' => 'In charge of managing, tracking, and maintaining all property and equipment within the system.',
            'Student Assistant' => 'Supports the Property Custodian in handling the day-to-day tasks of managing assets and equipment.',
        ];

        foreach ($roles as $roleName => $description) {
            $role = Role::create([
                'name' => $roleName,
                'description' => $description,
            ]);

            foreach (Permission::all() as $permission) {
                switch ($roleName) {
                    case 'Administrator':
                        $role->permissions()->attach($permission->id, [
                            'can_view' => 1,
                            'can_create' => 1,
                            'can_edit' => 1,
                            'can_delete' => 1,
                        ]);
                        break;

                    case 'Property Custodian':
                        $role->permissions()->attach($permission->id, [
                            'can_view' => 1,
                            'can_create' => 1,
                            'can_edit' => 0,
                            'can_delete' => 0,
                        ]);
                        break;

                    case 'Student Assistant':
                        $role->permissions()->attach($permission->id, [
                            'can_view' => 1,
                            'can_create' => 0,
                            'can_edit' => 0,
                            'can_delete' => 0,
                        ]);
                        break;
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
                'role' => 'Administrator',
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

        $batchUuid = (string) Str::uuid();
        AuditHistory::query()->create([
            'log_name'      => 'user_management',
            'description'   => 'User has been updated in batch process',
            'subject_type'  => User::class,
            'subject_id'    => $user->id,
            'causer_type'   => User::class,
            'causer_id'     => $user->id,
            'event'         => 'updated',
            'properties'    => json_encode(['attribute' => 'value']),
            'batch_uuid'    => $batchUuid,
        ]);
    }
}
