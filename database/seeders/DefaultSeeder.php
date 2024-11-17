<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Dashboard;
use App\Models\Event;
use App\Models\Progress;
use App\Models\Type;
use Illuminate\Database\Seeder;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            'Primary' => 'badge text-bg-primary',
            'Primary-soft' => 'badge bg-soft-primary text-primary',
            'Secondary' => 'badge text-bg-secondary',
            'Success' => 'badge text-bg-success',
            'Success-soft' => 'badge bg-soft-success text-success',
            'Danger' => 'badge text-bg-danger',
            'Danger-soft' => 'badge bg-soft-danger text-danger',
            'Warning' => 'badge text-bg-warning',
            'Warning-soft' => 'badge bg-soft-warning text-warning',
            'Info' => 'badge text-bg-info',
            'Info-soft' => 'badge bg-soft-info text-info',
            'Light' => 'badge text-bg-light',
            'Dark' => 'badge text-bg-dark',
            'Dark-soft' => 'badge bg-soft-dark text-dark',
            'Default-indicator' => 'legend-indicator',
            'Primary-indicator' => 'legend-indicator bg-primary',
            'Success-indicator' => 'legend-indicator bg-success',
            'Info-indicator' => 'legend-indicator bg-info',
            'Warning-indicator' => 'legend-indicator bg-warning',
            'Danger-indicator' => 'legend-indicator bg-danger',
            'Dark-indicator' => 'legend-indicator bg-dark',
        ];

        foreach ($colors as $color => $class) {
            Color::create([
                'name' => $color,
                'class' => $class,
            ]);
        }

        $dashboards = [
            'Admin Dashboard' => 'Comprehensive dashboard for administrative details.',
            'Default Dashboard' => 'Manage and track property and asset details.',
        ];

        foreach ($dashboards as $dashboard => $description) {
            Dashboard::create([
                'name' => $dashboard,
                'description' => $description,
            ]);
        }

        $events = [
            'Created' => [
                'badge_id' => 2,
                'legend_id' => 16,
            ],
            'Updated' => [
                'badge_id' => 5,
                'legend_id' => 17,
            ],
            'Deleted' => [
                'badge_id' => 7,
                'legend_id' => 20,
            ],
            'Login' => [
                'badge_id' => 11,
                'legend_id' => 18,
            ],
            'Logout' => [
                'badge_id' => 14,
                'legend_id' => 21,
            ],
        ];

        foreach ($events as $event => $data) {
            Event::create([
                'name' => $event,
                'badge_id' => $data['badge_id'],
                'legend_id' => $data['legend_id'],
            ]);
        }

        $progresses = [
            'Pending' => [
                'badge_id' => 11,
                'legend_id' => 18,
            ],
            'Approved' => [
                'badge_id' => 5,
                'legend_id' => 17,
            ],
            'Disapproved' => [
                'badge_id' => 7,
                'legend_id' => 20,
            ],
            'In Progress' => [
                'badge_id' => 2,
                'legend_id' => 16,
            ],
            'Completed' => [
                'badge_id' => 5,
                'legend_id' => 17,
            ],
        ];

        foreach ($progresses as $progress => $data) {
            Progress::create([
                'name' => $progress,
                'badge_id' => $data['badge_id'],
                'legend_id' => $data['legend_id'],
            ]);
        }

        $types = [
            'Ticket Request',
            'User',
            'Role',
            'Brand',
            'Category',
            'Department',
            'Designation',
        ];

        foreach ($types as $type) {
            Type::create([
                'name' => $type,
            ]);
        }
    }
}
