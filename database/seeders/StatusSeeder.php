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
            'Available' => 'This asset is ready for use and can be utilized immediately for its intended purpose without any restrictions.',
            'In Use' => 'The asset is currently being used and is not available for others until it becomes free.',
            'Unavailable' => 'The asset is not accessible for use at the moment due to unforeseen reasons or temporary constraints.',
            'Needs Maintenance' => 'The asset is in need of repair or service before it can be safely or effectively used again.',
            'Under Maintenance' => 'This asset is currently undergoing repairs or servicing to restore its full functionality.',
            'Reserved' => 'The asset has been booked for a future time and is not available for current use by others.',
            'Missing' => 'This asset is unaccounted for and cannot be found within the inventory or asset tracking system.',
            'End of Life' => 'This asset has reached the end of its usable service life and is no longer fit for operational use.',
            'Disposed' => 'This asset has been permanently removed from the inventory and is no longer available for use or tracking.'
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
