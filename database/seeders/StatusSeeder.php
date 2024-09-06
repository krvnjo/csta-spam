<?php

namespace Database\Seeders;

use App\Models\Condition;
use App\Models\Priority;
use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conditions = [
            'Working' => 'In good operational condition.',
            'Working w/ Minor Defects' => 'Operational with minor issues that do not affect functionality significantly.',
            'Working w/ Major Defects' => 'Operational but has significant issues that may affect functionality.',
            'Not Working' => 'Non-functional and requires repair, replacement, or disposal.'
        ];

        foreach ($conditions as $condition => $description) {
            Condition::query()->create([
                'name' => $condition,
                'description' => $description
            ]);
        }

        $statuses = [
            'Available' => 'Ready for use.',
            'In Use' => 'Currently in use.',
            'Unavailable' => 'Not accessible.',
            'Needs Maintenance' => 'Requires repair.',
            'Under Maintenance' => 'Being repaired.',
            'Reserved' => 'Booked for future use.',
            'Missing' => 'Asset is lost.',
            'End of Life' => 'Beyond serviceable use.',
            'Disposed' => 'Removed from inventory.',
        ];

        foreach ($statuses as $status => $description) {
            Status::query()->create([
                'name' => $status,
                'description' => $description
            ]);
        }

        $priorities = [
            'Urgent',
            'High',
            'Medium',
            'Low'
        ];

        foreach ($priorities as $priority) {
            Priority::query()->create([
                'name' => $priority
            ]);
        }
    }
}
