<?php

namespace Database\Seeders;

use App\Models\Groups;
use App\Models\Moderator;
use App\Models\Organization;
use App\Models\VNumbers;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ga = VNumbers::create([
            'vnumber' => '17815271298',
            'type' => 'GA',
            'initialize' => '1',
            'API_Token' => 'i39p8eyg3zp6marq',
            'API_InstanceID' => '144955',
            'API_Url' => 'https://eu200.chat-api.com',
        ]);
        $cb = VNumbers::create([
            'vnumber' => '17812681369',
            'type' => 'CB',
            'initialize' => '1',
            'API_Token' => 's3juqh3yk1541wt5',
            'API_InstanceID' => '144954',
            'API_Url' => 'https://eu200.chat-api.com',
        ]);
        $org = [
            'name' => 'Internal_Test', 'active' => 1, 'start_date' => Carbon::now('Asia/Kolkata'), 'institution_type' => 'UDC',
            'moderator_type' => 'AW'];
        $nwOrg = Organization::create($org);
        $nwOrg->NumbersAssociated()->attach($ga->vnumber,
            ['role' => 'GA']);

        $nwOrg->NumbersAssociated()->attach($cb->vnumber,
            ['role' => 'CB']);
        $moderator = [
            'name' => 'TechAdmin',
            'phone' => '919940127603',
            'active' => true,
            'user_id' => 1,
            'organization_id' => $nwOrg->id,
        ];
        $nwMod = Moderator::create($moderator);
        $node = Moderator::first();
        $nwMod->appendToNode($node)->save();
        $nwGrp = Groups::create([
            'name' => 'Rocket forwarding team',
            'active' => true,
            'type' => 'Moderators',
            'language' => 'hi',
            'user_id' => 1,
            'organization_id' => $nwOrg->id,
            'verified' => 1,
            'whatsapp_id' => '917657884236-1591782115@g.us',
        ]);
        $nwGrp->GroupsModerators()->attach($nwMod->id, ['main' => true]);
        $nwGrp->GroupsNumbers()->attach($cb->vnumber,
            ['role' => 'CB', 'added' => 1, 'admin' => 1]);
        $nwGrp->GroupsNumbers()->attach($ga->vnumber,
            ['role' => 'GA', 'added' => 1, 'admin' => 1]);
    }
}
