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
            'Primary' => [
                'class' => 'badge text-bg-primary',
                'is_color' => 1
            ],
            'Primary-soft' => [
                'class' => 'badge bg-soft-primary text-primary',
                'is_color' => 1
            ],
            'Secondary' => [
                'class' => 'badge text-bg-secondary',
                'is_color' => 1
            ],
            'Success' => [
                'class' => 'badge text-bg-success',
                'is_color' => 1
            ],
            'Success-soft' => [
                'class' => 'badge bg-soft-success text-success',
                'is_color' => 1
            ],
            'Danger' => [
                'class' => 'badge text-bg-danger',
                'is_color' => 1
            ],
            'Danger-soft' => [
                'class' => 'badge bg-soft-danger text-danger',
                'is_color' => 1
            ],
            'Warning' => [
                'class' => 'badge text-bg-warning',
                'is_color' => 1
            ],
            'Warning-soft' => [
                'class' => 'badge bg-soft-warning text-warning',
                'is_color' => 1
            ],
            'Info' => [
                'class' => 'badge text-bg-info',
                'is_color' => 1
            ],
            'Info-soft' => [
                'class' => 'badge bg-soft-info text-info',
                'is_color' => 1
            ],
            'Light' => [
                'class' => 'badge text-bg-light',
                'is_color' => 1
            ],
            'Dark' => [
                'class' => 'badge text-bg-dark',
                'is_color' => 1
            ],
            'Red-indicator' => [
                'class' => 'legend-indicator bg-danger',
                'is_color' => 0
            ],
            'Yellow-indicator' => [
                'class' => 'legend-indicator bg-warning',
                'is_color' => 0
            ],
            'Green-indicator' => [
                'class' => 'legend-indicator bg-success',
                'is_color' => 0
            ],
            'Blue-indicator' => [
                'class' => 'legend-indicator bg-primary',
                'is_color' => 0
            ],
            'Default-indicator' => [
                'class' => 'legend-indicator',
                'is_color' => 0
            ],
        ];

        foreach ($colors as $color => $data) {
            Color::query()->create([
                'name' => $color,
                'class' => $data['class'],
                'is_color' => $data['is_color'],
                'is_active' => 1
            ]);
        }

        $conditions = [
            'Working' => 'Item works properly without issues or repairs needed.',
            'Working with Minor Defects' => 'Item works but has minor defects that don’t affect use.',
            'Working with Major Defects' => 'Item works with major defects affecting performance.',
            'Not Working' => 'Item is non-functional and needs repair or replacement.'
        ];

        foreach ($conditions as $condition => $description) {
            Condition::query()->create([
                'name' => $condition,
                'description' => $description,
                'is_active' => 1
            ]);
        }

        $statuses = [
            'Available' => [
                'description' => 'Item is ready for immediate use.',
                'color_id' => 4,
            ],
            'In Use' => [
                'description' => 'Item is currently being used.',
                'color_id' => 1,
            ],
            'Unavailable' => [
                'description' => 'Item is temporarily unavailable.',
                'color_id' => 3,
            ],
            'Needs Maintenance' => [
                'description' => 'Item needs repairs before use.',
                'color_id' => 8,
            ],
            'Under Maintenance' => [
                'description' => 'Item is currently being repaired.',
                'color_id' => 9,
            ],
            'Reserved' => [
                'description' => 'Item is reserved and not available.',
                'color_id' => 10,
            ],
            'Missing' => [
                'description' => 'Item is missing and unaccounted for.',
                'color_id' => 6,
            ],
            'End of Life' => [
                'description' => 'Item is no longer usable and at the end of life.',
                'color_id' => 12,
            ],
            'Disposed' => [
                'description' => 'Item has been permanently removed.',
                'color_id' => 13,
            ]
        ];

        foreach ($statuses as $status => $data) {
            Status::query()->create([
                'name' => $status,
                'description' => $data['description'],
                'color_id' => $data['color_id'],
                'is_active' => 1
            ]);
        }

        $priorities = [
            'Urgent' => [
                'description' => 'Needs immediate action and attention.',
                'color_id' => 14
            ],
            'High' => [
                'description' => 'Should be addressed soon.',
                'color_id' => 15
            ],
            'Medium' => [
                'description' => 'Can be scheduled but important.',
                'color_id' => 16
            ],
            'Low' => [
                'description' => 'Can be addressed later without urgency.',
                'color_id' => 17
            ],
        ];

        foreach ($priorities as $priority => $data) {
            Priority::query()->create([
                'name' => $priority,
                'description' => $data['description'],
                'color_id' => $data['color_id'],
                'is_active' => 1
            ]);
        }
    }
}
