<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            ['type' => 'system_name', 'description' => 'School CEP System'],
            ['type' => 'system_title', 'description' => 'SCHOOL'],
            ['type' => 'current_session', 'description' => '2026-2027'],
            ['type' => 'phone', 'description' => '+1234567890'],
            ['type' => 'system_email', 'description' => 'admin@school.com'],
            ['type' => 'address', 'description' => '123 School Street'],
            ['type' => 'term_ends', 'description' => '12-31-2026'],
            ['type' => 'term_begins', 'description' => '01-01-2027'],
            ['type' => 'lock_exam', 'description' => '0'],
            ['type' => 'logo', 'description' => asset('global_assets/images/favicon.png')],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(
                ['type' => $setting['type']],
                ['description' => $setting['description']]
            );
        }
    }
}
