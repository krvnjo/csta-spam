<?php

namespace Database\Seeders;

use App\Models\Acquisition;
use App\Models\Brand;
use App\Models\BrandSubcategory;
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
                'name' => $acquisition,
                'is_active' => 1
            ]);
        }

        $brands = [
            'Generic',
            'A4Tech',
            'Carrier',
            'MSI',
            'TCL',
            'Samsung'
        ];

        foreach ($brands as $brand) {
            Brand::query()->create([
                'name' => $brand,
                'is_active' => 1
            ]);
        }

        $categories = [
            'Electronics',
            'Furniture',
            'Tools and Equipment',
            'Materials',
            'Supplies'
        ];

        foreach ($categories as $category) {
            Category::query()->create([
                'name' => $category,
                'is_active' => 1
            ]);
        }

        $subcategories = [
            'Monitor' => '1',
            'Keyboard' => '1',
            'Mouse' => '1',
            'TV' => '1',
            'Air Conditioner' => '1',
            'Cables' => '1',
            'Table' => '2',
            'Chair' => '2',
            'Desks' => '2',
            'Bench' => '2'
        ];

        foreach ($subcategories as $subcategory => $categId) {
            Subcategory::query()->create([
                'name' => $subcategory,
                'categ_id' => $categId,
                'is_active' => 1
            ]);
        }

        $brandSubcategories = [
            ['brand_id' => 6, 'subcateg_id' => 1],
            ['brand_id' => 6, 'subcateg_id' => 4],
            ['brand_id' => 6, 'subcateg_id' => 9],
            ['brand_id' => 2, 'subcateg_id' => 2],
            ['brand_id' => 2, 'subcateg_id' => 3],
            ['brand_id' => 1, 'subcateg_id' => 10],
            ['brand_id' => 3, 'subcateg_id' => 9],
            ['brand_id' => 4, 'subcateg_id' => 1],
            ['brand_id' => 5, 'subcateg_id' => 4],
        ];

        foreach ($brandSubcategories as $brandSubcategory) {
            BrandSubcategory::query()->insert($brandSubcategory);
        }
    }
}
