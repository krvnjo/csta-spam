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
            'Fully Operational' => [
                'description' => 'Item is fully working.',
                'color_id' => 15,
            ],
            'Partially Working' => [
                'description' => 'Item has small issues, still usable.',
                'color_id' => 16,
            ],
            'Working with Major Issues' => [
                'description' => 'Item has significant issues affecting use.',
                'color_id' => 18,
            ],
            'Not Working' => [
                'description' => 'Item not usable and needs repair or replacement.',
                'color_id' => 19,
            ],
        ];

        foreach ($conditions as $condition => $data) {
            Condition::create([
                'name' => $condition,
                'description' => $data['description'],
                'color_id' => $data['color_id'],
            ]);
        }

        $priorities = [
            'Urgent' => [
                'description' => 'Needs immediate action and attention.',
                'order' => 1,
                'color_id' => 19,
            ],
            'High' => [
                'description' => 'Should be addressed soon.',
                'order' => 2,
                'color_id' => 18,
            ],
            'Medium' => [
                'description' => 'Can be scheduled but important.',
                'order' => 3,
                'color_id' => 16,
            ],
            'Low' => [
                'description' => 'Can be addressed later without urgency.',
                'order' => 4,
                'color_id' => 15,
            ],
        ];

        foreach ($priorities as $priority => $data) {
            Priority::create([
                'name' => $priority,
                'description' => $data['description'],
                'order' => $data['order'],
                'color_id' => $data['color_id'],
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
                'description' => 'Item is no longer usable and obsolete.',
                'color_id' => 12,
            ],
            'Disposed' => [
                'description' => 'Item has been permanently removed from CSTA.',
                'color_id' => 13,
            ],
        ];

        foreach ($statuses as $status => $data) {
            Status::create([
                'name' => $status,
                'description' => $data['description'],
                'color_id' => $data['color_id'],
            ]);
        }
    }
}
