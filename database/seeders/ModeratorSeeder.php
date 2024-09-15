<?php

namespace Database\Seeders;

use App\Models\Moderator;
use Illuminate\Database\Seeder;

class ModeratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $moderator = [
            'name' => 'ModeratorAdmin',
            'phone' => '015859672928',
            'active' => false,
            'user_id' => 1,
            'organization_id' => 0,
        ];
        Moderator::create($moderator)->makeRoot()->save();
    }
}
