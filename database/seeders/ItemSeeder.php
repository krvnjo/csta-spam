<?php

namespace Database\Seeders;

use App\Models\PropertyChild;
use App\Models\PropertyParent;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $Parent = [
            [
                'name' => 'S-Inverter AR09TYHYEWKNTC',
                'brand_id' => 6,
                'categ_id' => 5,
                'description' => '1.5HP Window Type Air Conditioner',
                'image' => 'default.jpg',
                'quantity' => 15,
                'is_active' => 1,
                'purchase_price' => 25000.00,
                'residual_value' => 5000.00,
                'useful_life' => 5,
            ],
            [
                'name' => 'C655 QLED',
                'brand_id' => 5,
                'categ_id' => 4,
                'description' => '55 inch QLED 4K UHD Smart TV',
                'image' => 'default.jpg',
                'quantity' => 20,
                'is_active' => 1,
                'purchase_price' => 15000.00,
                'residual_value' => 3000.00,
                'useful_life' => 5,
            ],
            [
                'name' => 'Teacher\'s Table',
                'brand_id' => 1,
                'categ_id' => 7,
                'description' => 'Wooden Table with 2 drawers',
                'image' => 'default.jpg',
                'quantity' => 25,
                'is_active' => 1,
                'purchase_price' => 1500,
                'residual_value' => 400,
                'useful_life' => 8,
            ],
        ];

        foreach ($Parent as $parentData) {
            $parent = PropertyParent::create($parentData);

            for ($i = 0; $i < $parentData['quantity']; $i++) {
                $propCode = $this->generateUniquePropCode();

                $serialNum = $this->generateUniqueSerial();
                $typeId = rand(1, 2);
                $acqDate = $this->randomPastDate();
                $warrantyDate = ($typeId == 1) ? $this->randomFutureDate() : null;

                $isStock = rand(0, 1) === 1;

                $excluded = [1, 6, 8, 9];
                $options = array_diff(range(2, 9), $excluded);
                $deptId = $isStock ? 1 : rand(2, 5);
                $desigId = $isStock ? 1 : rand(2, 11);
                $statusId = $isStock ? 1 : Arr::random($options);
                $inventoryDate = $isStock ? null : $this->randomDate();
                $stockDate = Carbon::now();

                PropertyChild::create([
                    'prop_id' => $parent->id,
                    'prop_code' => $propCode,
                    'serial_num' => $serialNum,
                    'type_id' => $typeId,
                    'acq_date' => $acqDate,
                    'warranty_date' => $warrantyDate,
                    'stock_date' => $stockDate,
                    'inventory_date' => $inventoryDate,
                    'dept_id' => $deptId,
                    'desig_id' => $desigId,
                    'condi_id' => rand(1, 4),
                    'status_id' => $statusId,
                    'remarks' => '',
                    'is_active' => 1,
                ]);
            }
        }
    }

    private function generateUniquePropCode(): string
    {
        $lastCode = PropertyChild::orderBy('prop_code', 'desc')->pluck('prop_code')->first();

        if ($lastCode) {
            $lastNumber = intval(substr($lastCode, 4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return '2024' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }


    private function generateUniqueSerial(): int
    {
        do {
            $serial = mt_rand(10000000, 99999999);
        } while (PropertyChild::where('serial_num', $serial)->exists());

        return $serial;
    }

    private function randomDate(): string
    {
        $endDate = null;
        $startDate = null;

        if (!(null)) {
            $startDate = strtotime('-3 years');
        }
        if (!(null)) {
            $endDate = strtotime('now');
        }
        return date('Y-m-d', mt_rand($startDate, $endDate));
    }

    private function randomPastDate(): string
    {
        $startDate = strtotime('-3 years');
        $endDate = strtotime('now');
        return date('Y-m-d', mt_rand($startDate, $endDate));
    }

    private function randomFutureDate(): string
    {
        $startDate = strtotime('now');
        $endDate = strtotime('+5 years');
        return date('Y-m-d', mt_rand($startDate, $endDate));
    }
}
