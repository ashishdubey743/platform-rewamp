<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VNumbersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        // Generate 20 unique records
        for ($i = 1; $i <= 20; $i++) {
            $data[] = [
                'vnumber' => '91' . mt_rand(1000000000, 9999999999), // Generates a random unique vnumber
                'block_date' => null,
                'deactive_date' => null,
                'active' => true,
                'blocked' => false,
                'initialize' => false,
                'type' => 'Basic', // Default type
                'API_Token' => Str::random(60), // Generate a random unique token
                'API_InstanceID' => Str::uuid()->toString(), // Generate a random unique Instance ID
                'API_Url' => 'https://api.example.com/' . Str::random(10), // Generate a mock API URL
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert the data into the v_numbers table
        DB::table('v_numbers')->insert($data);
    }
}
