<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Dashboard;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Event;
use App\Models\Role;
use App\Models\Type;
use App\Models\User;
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
            'Property & Asset Dashboard' => 'Manage  and track property and asset details.',
            'Default Dashboard' => 'General user dashboard with essential tools.',
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
                'legend_id' => 15,
            ],
            'Updated' => [
                'badge_id' => 5,
                'legend_id' => 16,
            ],
            'Deleted' => [
                'badge_id' => 7,
                'legend_id' => 19,
            ],
            'Login' => [
                'badge_id' => 11,
                'legend_id' => 17,
            ],
            'Logout' => [
                'badge_id' => 11,
                'legend_id' => 17,
            ],
        ];

        foreach ($events as $event => $data) {
            Event::create([
                'name' => $event,
                'badge_id' => $data['badge_id'],
                'legend_id' => $data['legend_id'],
            ]);
        }

        $types = [
            'User' => User::class,
            'Role' => Role::class,
            'Brand' => Brand::class,
            'Category' => Category::class,
            'Department' => Department::class,
            'Designation' => Designation::class,
        ];

        foreach ($types as $type => $class) {
            Type::create([
                'name' => $type,
                'class' => $class,
            ]);
        }
    }
}
