<?php

namespace Database\Seeders;

use App\Models\Condition;
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
            'Fully Functional' => [
                'description' => 'Item is fully working and usable.',
                'color_id' => 16,
            ],
            'Working with Minor Issues' => [
                'description' => 'Item has small issues but still usable.',
                'color_id' => 17,
            ],
            'Working with Major Issues' => [
                'description' => 'Item has significant issues affecting use.',
                'color_id' => 19,
            ],
            'Not Working' => [
                'description' => 'Item unusable and needs repair or replacement.',
                'color_id' => 20,
            ],
        ];

        foreach ($conditions as $condition => $data) {
            Condition::create([
                'name' => $condition,
                'description' => $data['description'],
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
            'Needs Maintenance' => [
                'description' => 'Item needs repairs before use.',
                'color_id' => 9,
            ],
            'Under Maintenance' => [
                'description' => 'Item is currently being repaired.',
                'color_id' => 8,
            ],
            'Reserved' => [
                'description' => 'Item is reserved and not available.',
                'color_id' => 11,
            ],
            'Borrowed' => [
                'description' => 'Item is currently borrowed and in use.',
                'color_id' => 10,
            ],
            'Missing' => [
                'description' => 'Item is missing and unaccounted for.',
                'color_id' => 6,
            ],
            'For Replacement' => [
                'description' => 'Item needs replacement and can be disposed.',
                'color_id' => 12,
            ],
            'For Disposal' => [
                'description' => 'Item is no longer usable and EOL.',
                'color_id' => 14,
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
