<?php

namespace Database\Seeders;

use App\Models\Color;
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
        $colors = [
            'Primary' => 'badge bg-primary fs-6',
            'Primary-soft' => 'badge bg-soft-primary text-primary fs-6',
            'Secondary' => 'badge bg-secondary fs-6',
            'Secondary-soft' => 'badge bg-soft-secondary text-secondary fs-6',
            'Success' => 'badge bg-success fs-6',
            'Success-soft' => 'badge bg-soft-success text-success fs-6',
            'Danger' => 'badge bg-danger fs-6',
            'Danger-soft' => 'badge bg-soft-danger text-danger fs-6',
            'Warning' => 'badge bg-warning fs-6',
            'Warning-soft' => 'badge bg-soft-warning text-warning fs-6',
            'Info' => 'badge bg-info fs-6',
            'Info-soft' => 'badge bg-soft-info text-info fs-6',
            'Light' => 'badge bg-light text-dark fs-6',
            'Light-soft' => 'badge bg-soft-light text-dark fs-6',
            'Dark' => 'badge bg-dark fs-6',
            'Dark-soft' => 'badge bg-soft-dark text-dark fs-6',
        ];

        foreach ($colors as $color => $class) {
            Color::query()->create([
                'name' => $color,
                'color_class' => $class
            ]);
        }

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
            'Available' => [
                'description' => 'Asset is ready for immediate use without any restrictions.',
                'color_id' => 1,
            ],
            'In Use' => [
                'description' => 'Asset is currently in use and not available for others.',
                'color_id' => 2,
            ],
            'Unavailable' => [
                'description' => 'Asset is temporarily inaccessible due to unforeseen reasons.',
                'color_id' => 3,
            ],
            'Needs Maintenance' => [
                'description' => 'Asset requires repair or service before it can be used again.',
                'color_id' => 4,
            ],
            'Under Maintenance' => [
                'description' => 'Asset is being repaired or serviced to restore functionality.',
                'color_id' => 5,
            ],
            'Reserved' => [
                'description' => 'Asset is booked for future use and unavailable for others.',
                'color_id' => 6,
            ],
            'Missing' => [
                'description' => 'Asset is unaccounted for and cannot be found in the inventory.',
                'color_id' => 7,
            ],
            'End of Life' => [
                'description' => 'Asset has reached the end of its useful life and is no longer usable.',
                'color_id' => 8,
            ],
            'Disposed' => [
                'description' => 'Asset has been permanently removed from inventory and use.',
                'color_id' => 9,
            ]
        ];

        foreach ($statuses as $status => $data) {
            Status::query()->create([
                'name' => $status,
                'description' => $data['description'],
                'color_id' => $data['color_id']
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
