<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the AdminUser
        $adminUser = User::create([
            'name' => 'AdminUser',
            'email' => 'tech@rocketlearning.org',
            'password' => bcrypt('ece@1234'), // Encrypt password
        ]);

        // Assign the 'TechAdmin' role to the AdminUser
        $techAdminRole = Role::where('name', 'TechAdmin')->first();
        if ($techAdminRole) {
            $adminUser->assignRole($techAdminRole);
        }

        // Create the Platform Admin User (for testing purpose)
        $platformAdminUser = User::create([
            'name' => 'Platform Admin',
            'email' => 'platformadmin@rocketlearning.org',
            'password' => bcrypt('ece@1234'), // Encrypt password
        ]);

        // Assign the 'PlatformAdmin' role to the Platform Admin User
        $platformAdminRole = Role::where('name', 'PlatformAdmin')->first();
        if ($platformAdminRole) {
            $platformAdminUser->assignRole($platformAdminRole);
        }
    }
}
