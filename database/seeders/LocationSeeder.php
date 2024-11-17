<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Designation;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'CSTA Administration' => 'ADMIN',
            'Information Technology' => 'SIT',
            'Education' => 'SED',
            'Hospitality and Tourism Management' => 'SHTM',
            'Accounting' => 'ACC',
            'Registar' => 'REG',
        ];

        foreach ($departments as $department => $code) {
            Department::create([
                'name' => $department,
                'code' => $code,
            ]);
        }

        $designations = [
            'Stock Room' => '1',
            'Gym Court' => '1',
            'Gym Technical Room' => '2',
            'Gym IT Laboratory 1' => '2',
            'Gym IT Laboratory 2' => '2',
            'Gym IT Laboratory 3' => '2',
            'Gym IT Laboratory 4' => '2',
            'Gym IT Laboratory 5' => '2',
            'Gym IT Technical Laboratory' => '2',
            'Gym IT Networking Lab' => '2',
            'Gym IT Hallway' => '2',
        ];

        foreach ($designations as $designation => $department) {
            Designation::create([
                'name' => $designation,
                'dept_id' => $department,
            ]);
        }
    }
}
