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
        $depts = [
            'CSTA Administration' => 'CSTA-ADMIN',
            'School of Information Technology' => 'SIT',
            'School of Education' => 'SED',
            'School of Tourism Management' => 'STM',
            'School of Hospitality Management' => 'SHM'
        ];

        foreach ($depts as $dept => $deptCode) {
            Department::query()->create([
                'name' => $dept,
                'dept_code' => $deptCode
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
            'Gym IT Hallway' => '2'
        ];

        foreach ($designations as $designation => $deptId) {
            Designation::query()->create([
                'name' => $designation,
                'dept_id' => $deptId
            ]);
        }
    }
}
