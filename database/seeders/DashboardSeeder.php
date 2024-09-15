<?php

namespace Database\Seeders;

use App\Models\Dashboard;
use Illuminate\Database\Seeder;

class DashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'category' => 'content',
                'type' => 'AS',
                'type_name' => 'Activities Summary',
                'created_at' => now(),
            ],
            [
                'category' => 'engagement',
                'type' => 'ES',
                'type_name' => 'Engagement Summary',
                'created_at' => now(),
            ],
            [
                'category' => 'coverage',
                'type' => 'CS',
                'type_name' => 'Coverage Summary',
                'created_at' => now(),
            ],
            [
                'category' => 'activation',
                'type' => 'ACS',
                'type_name' => 'Activation Summary',
                'created_at' => now(),
            ],
        ];
        Dashboard::insert($data);
    }
}
