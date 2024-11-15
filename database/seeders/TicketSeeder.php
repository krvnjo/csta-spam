<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tickets = [
            [
                'name' => '202400001',
                'description' => 'The printer is not working and jammed',
                'total_cost' => 1000.00,
                'prio_id' => 1,
                'prog_id' => 1,
            ],
        ];

        foreach ($tickets as $data) {
            Ticket::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'total_cost' => $data['total_cost'],
                'prio_id' => $data['prio_id'],
                'prog_id' => $data['prog_id'],
            ]);
        }
    }
}
