<?php

namespace Database\Seeders;

use App\Models\Acquisition;
use App\Models\Brand;
use App\Models\BrandSubcategory;
use App\Models\Category;
use App\Models\CategorySubcategory;
use App\Models\Subcategory;
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
            Acquisition::query()->create([
                'name' => $acquisition,
            ]);
        }

        $brands = [
            'Generic',
            'A4tech',
            'Carrier',
            'Msi',
            'Samsung',
            'Tcl',
            'Uratex'
        ];

        foreach ($brands as $brand) {
            Brand::query()->create([
                'name' => $brand,
            ]);
        }

        $categories = [
            'Electronics',
            'Equipment',
            'Furniture',
            'Materials',
            'Supplies',
            'Tools'
        ];

        foreach ($categories as $category) {
            Category::query()->create([
                'name' => $category,
            ]);
        }

        $subcategories = [
            'Air Conditioner',
            'Bench',
            'Cable',
            'Chair',
            'Desk',
            'Keyboard',
            'Monitor',
            'Mouse',
            'Paper',
            'Table',
            'Television'
        ];

        foreach ($subcategories as $subcategory) {
            Subcategory::query()->create([
                'name' => $subcategory,
            ]);
        }

        $brandSubcategories = [
            ['brand_id' => 1, 'subcateg_id' => 1],
            ['brand_id' => 1, 'subcateg_id' => 2],
            ['brand_id' => 1, 'subcateg_id' => 3],
            ['brand_id' => 1, 'subcateg_id' => 4],
            ['brand_id' => 1, 'subcateg_id' => 5],
            ['brand_id' => 1, 'subcateg_id' => 6],
            ['brand_id' => 1, 'subcateg_id' => 7],
            ['brand_id' => 1, 'subcateg_id' => 8],
            ['brand_id' => 1, 'subcateg_id' => 9],
            ['brand_id' => 1, 'subcateg_id' => 10],
            ['brand_id' => 1, 'subcateg_id' => 11],
            ['brand_id' => 2, 'subcateg_id' => 6],
            ['brand_id' => 2, 'subcateg_id' => 8],
            ['brand_id' => 3, 'subcateg_id' => 1],
            ['brand_id' => 4, 'subcateg_id' => 7],
            ['brand_id' => 4, 'subcateg_id' => 6],
            ['brand_id' => 4, 'subcateg_id' => 8],
            ['brand_id' => 5, 'subcateg_id' => 7],
            ['brand_id' => 5, 'subcateg_id' => 11],
            ['brand_id' => 5, 'subcateg_id' => 1],
            ['brand_id' => 6, 'subcateg_id' => 11],
            ['brand_id' => 7, 'subcateg_id' => 10],
            ['brand_id' => 7, 'subcateg_id' => 4],
            ['brand_id' => 7, 'subcateg_id' => 5],
            ['brand_id' => 7, 'subcateg_id' => 2],
        ];

        foreach ($brandSubcategories as $brandSubcategory) {
            BrandSubcategory::query()->insert($brandSubcategory);
        }

        $categorySubcategories = [
            ['categ_id' => 1, 'subcateg_id' => 1],
            ['categ_id' => 1, 'subcateg_id' => 6],
            ['categ_id' => 1, 'subcateg_id' => 7],
            ['categ_id' => 1, 'subcateg_id' => 8],
            ['categ_id' => 1, 'subcateg_id' => 11],
            ['categ_id' => 2, 'subcateg_id' => 1],
            ['categ_id' => 2, 'subcateg_id' => 7],
            ['categ_id' => 3, 'subcateg_id' => 2],
            ['categ_id' => 3, 'subcateg_id' => 4],
            ['categ_id' => 3, 'subcateg_id' => 5],
            ['categ_id' => 3, 'subcateg_id' => 10],
            ['categ_id' => 4, 'subcateg_id' => 9],
            ['categ_id' => 5, 'subcateg_id' => 3],
            ['categ_id' => 5, 'subcateg_id' => 9],
            ['categ_id' => 6, 'subcateg_id' => 6],
            ['categ_id' => 6, 'subcateg_id' => 8],
        ];

        foreach ($categorySubcategories as $categorySubcategory) {
            CategorySubcategory::query()->insert($categorySubcategory);
        }

        $units = [
            'Ream',
            'Pc/s',
            'Box',
            'Gallon',
        ];

        foreach ($units as $unit) {
            Unit::query()->create([
                'name' => $unit,
            ]);
        }
    }
}
