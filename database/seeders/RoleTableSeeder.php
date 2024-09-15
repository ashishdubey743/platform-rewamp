<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'InviteUsers']);
        Permission::create(['name' => 'SeeUsers']);
        Permission::create(['name' => 'SeeAllModerators']);
        Permission::create(['name' => 'PlatformBeta']);
        Permission::create(['name' => 'PlatformInsider']);
        Role::create(['name' => 'TechAdmin'])->givePermissionTo(['InviteUsers', 'SeeUsers', 'SeeAllModerators']);
        Role::create(['name' => 'ContentAdmin'])->givePermissionTo(['SeeUsers', 'SeeAllModerators']);
        Role::create(['name' => 'PlatformAdmin'])->givePermissionTo(['InviteUsers', 'SeeUsers', 'SeeAllModerators', 'PlatformBeta', 'PlatformInsider']);
    }
}
