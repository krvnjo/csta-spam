<?php

namespace Database\Seeders;

use App\Models\Acquisition;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
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
            Acquisition::query()->create([
                'name' => $acquisition
            ]);
        }

        $brands = [
            'Generic',
            'A4Tech',
            'Carrier',
            'MSI',
            'TCL'
        ];

        foreach ($brands as $brand) {
            Brand::query()->create([
                'name' => $brand
            ]);
        }

        $categories = [
            'Electronics',
            'Furniture',
            'Appliances',
            'Tools',
            'Equipment',
            'Supplies',
            'Materials'
        ];

        foreach ($categories as $category) {
            Category::query()->create([
                'name' => $category
            ]);
        }

        $subcategories = [
            'Monitor' => '1',
            'Keyboard' => '1',
            'Mouse' => '1',
            'TV' => '1',
            'Table' => '2',
            'Chair' => '2',
            'Desks' => '2',
            'Bench' => '2',
            'Air Conditioner' => '3',
        ];

        foreach ($subcategories as $subcategory => $categId) {
            Subcategory::query()->create([
                'name' => $subcategory,
                'categ_id' => $categId
            ]);
        }
    }
}
