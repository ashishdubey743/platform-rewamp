<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ModeratorSeeder::class);
        $this->call(TestDataSeeder::class);
        //$this->call(ChdSeeder::class);
        $this->call(ActivitySeeder::class);
        $this->call(DashboardSeeder::class);
        $this->call(VNumbersSeeder::class);
    }
}
