<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'Session Timeout' => [
                'key' => 'session_timeout',
                'value' => '120',
            ],
            'Password Expiry' => [
                'key' => 'password_expiry',
                'value' => '6',
            ],
            'Clear Audit Log' => [
                'key' => 'clear_audit_log',
                'value' => '60',
            ],
            'Caching Duration' => [
                'key' => 'caching_duration',
                'value' => '120',
            ],
        ];

        foreach ($settings as $name => $data) {
            Setting::create([
                'name' => $name,
                'key' => $data['key'],
                'value' => $data['value'],
            ]);
        }
    }
}
