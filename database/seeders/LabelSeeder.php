<?php

namespace Database\Seeders;

use App\Models\Acquisition;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $acquisitions = [
            'Purchased',
            'Donation'
        ];

        foreach ($acquisitions as $acquisition) {
            Acquisition::create([
                'name' => $acquisition,
            ]);
        }

        $brands = [
            'GENERIC',
            'A4TECH',
            'CARRIER',
            'MSI',
            'SAMSUNG',
            'TCL',
            'URATEX'
        ];

        foreach ($brands as $brand) {
            Brand::create([
                'name' => $brand,
            ]);
        }

        $categories = [
            'AIR CONDITIONER',
            'BENCH',
            'CABLE',
            'CHAIR',
            'DESK',
            'KEYBOARD',
            'MONITOR',
            'MOUSE',
            'PAPER',
            'TABLE',
            'TELEVISION'
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
            ]);
        }

        $units = [
            'Ream',
            'Pc/s',
            'Box',
            'Gallon',
        ];

        foreach ($units as $unit) {
            Unit::create([
                'name' => $unit,
            ]);
        }
    }
}
