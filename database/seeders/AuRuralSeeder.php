<?php

namespace Database\Seeders;

use App\Models\Groups;
use App\Models\Guardian;
use App\Models\Interaction;
use App\Models\Intervention;
use App\Models\InterventionMessage;
use App\Models\InterventionMultimedia;
use App\Models\Kid;
use App\Models\Moderator;
use App\Models\Organization;
use App\Models\VNumbers;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Seeder;

class AuRuralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ga = VNumbers::firstOrCreate([
            'vnumber' => '917657884236',
            'type' => 'GA',
            'initialize' => '1',
            'API_Token' => 's5exqe48u577aueq',
            'API_InstanceID' => '147368',
            'API_Url' => 'https://eu200.chat-api.com',
        ]);
        $org1 = [
            'name' => 'Aurangabad Rural ICDS Maharashtra', 'active' => 1, 'start_date' => Carbon::parse('2020-06-10', 'Asia/Kolkata'), 'institution_type' => 'UDC',
            'moderator_type' => 'AW', 'state' => 'Maharashtra', 'district' => 'Aurangabad'];
        $nwOrg1 = Organization::firstOrCreate($org1);
        $nwOrg1->NumbersAssociated()->attach($ga->vnumber,
            ['role' => 'GA']);
        $chatBots = ['17813559759', '17817973225', '17812681369', '17813348880', '17815365029'];
        $insts = ['144950', '156680', '144954', '158057', '158098'];
        $tkns = ['6i1885atnivca590', 'fhqmy0k0zj31u6sw', 's3juqh3yk1541wt5', '6glvkvj1tegxjr79', '14vla6it4eqgwka8'];
        $cb = [];
        for ($c = 0; $c < count($chatBots); $c++) {
            $cb[$chatBots[$c]] = VNumbers::firstOrCreate([
                'vnumber' => $chatBots[$c],
                'type' => 'CB',
                'initialize' => '1',
                'API_Token' => $tkns[$c],
                'API_InstanceID' => $insts[$c],
                'API_Url' => 'https://eu200.chat-api.com',
            ]);
            $nwOrg1->NumbersAssociated()->attach($cb[$chatBots[$c]]->vnumber,
                ['role' => 'CB']);
        }
        $groupData = file_get_contents('http://phonebackups.blob.core.windows.net/seederdata/Aur_Rural/8_30_Aur_Group_Anlaysis.json');
        $groupData = json_decode($groupData, false);
        $parentData = file_get_contents('http://phonebackups.blob.core.windows.net/seederdata/Aur_Rural/8_30_Aur_Import_Parents.json');
        $parentData = json_decode($parentData, true);
        $modData = file_get_contents('http://phonebackups.blob.core.windows.net/seederdata/Aur_Rural/8_30_Aur_Import_Moderators_Grp.json');
        $modData = json_decode($modData, true);
        $orgModData = file_get_contents('http://phonebackups.blob.core.windows.net/seederdata/Aur_Rural/8_30_Aur_Import_Moderators.json');
        $orgModData = json_decode($orgModData, true);
        $modIntData = file_get_contents('http://phonebackups.blob.core.windows.net/seederdata/Aur_Rural/8_30_Aur_Import_Moderator_Interactions.json');
        $modIntData = json_decode($modIntData, true);
        $parIntData = file_get_contents('http://phonebackups.blob.core.windows.net/seederdata/Aur_Rural/8_30_Aur_Import_Parent_Interactions.json');
        $parIntData = json_decode($parIntData, true);
        $intervenData = file_get_contents('http://phonebackups.blob.core.windows.net/seederdata/Aur_Rural/8_30_Aur_Import_Interventions.json');
        $intervenData = json_decode($intervenData, true);
        $inmultData = file_get_contents('http://phonebackups.blob.core.windows.net/seederdata/Aur_Rural/8_30_Aur_Import_Interventions_Mult.json');
        $inmultData = json_decode($inmultData, true);
        $inmsgData = file_get_contents('http://phonebackups.blob.core.windows.net/seederdata/Aur_Rural/8_30_Aur_Import_Interventions_Msg.json');
        $inmsgData = json_decode($inmsgData, true);
        $AllMod = [];
        $exgrps = Groups::select('whatsapp_id')->get()->toArray();
        $tempArr = array_diff(array_unique(array_column($groupData, 'wid')), array_column($exgrps, 'whatsapp_id'));
        $groupData = array_intersect_key($groupData, $tempArr);
        foreach ($orgModData as $mod) {
            if (! array_key_exists($mod['phone'], $AllMod)) {
                $AllMod[$mod['phone']] = Moderator::firstOrCreate(['organization_id' => $nwOrg1->id, 'active' => 1, 'name' => $mod['name'],
                    'phone' => $mod['phone'], 'role' => $mod['role'], 'e_role' => $mod['e_role'], 'e_Identifiers' => $mod['e_Identifiers']]);
                if ($mod['phone'] == 918275265471) {
                    $node = Moderator::where('id', 1)->first();
                    $AllMod[$mod['phone']]->appendToNode($node)->save();
                } elseif ($mod['Report'] != '' && ! is_null($mod['Report']) && array_key_exists($mod['Report'], $AllMod)) {
                    $AllMod[$mod['phone']]->appendToNode($AllMod[$mod['Report']])->save();
                } else {
                    $AllMod[$mod['phone']]->appendToNode($AllMod[918275265471])->save();
                }
            }
        }
        $sndr = 0;
        $allnum = [];
        foreach ($groupData as $grp) {
            $gn = $grp->Group_name;
            $wid = $grp->wid;
            $grorg = $nwOrg1->id;
            $pars = [];
            if ($grp->Supervisor_Group == 0) {
                $type = 'Parents';
            } else {
                $type = 'Moderators';
            }
            $modInt = [];
            $parInt = [];
            $intervene = [];
            $interMult = [];
            $interMsg = [];
            $moderators = [$grp->MainAW_Whatsapp_No];
            if ($grp->NotTrust == 0) {
                if ($grp->Total_Sent > 0 && $grp->Admin_Rights > 0 && $grp->Assigned_Vnum != '917657884236') {
                    $sndr = 1;
                }
                $pars = array_filter($parentData, function ($a) use ($gn) {
                    return $a['Chat Session'] == $gn;
                });
                $pmod = array_filter($modData, function ($a) use ($gn) {
                    return $a['Group_name'] == $gn;
                });
                $pmod = array_unique(array_map(function ($i) {
                    return $i['phone'];
                }, $pmod));
                $moderators = array_unique(array_merge($moderators, $pmod));
                $modInt = array_filter($modIntData, function ($a) use ($gn) {
                    return $a['Chat.Session'] == $gn;
                });
                $parInt = array_filter($parIntData, function ($a) use ($gn) {
                    return $a['Chat.Session'] == $gn;
                });
                $intervene = array_filter($intervenData, function ($a) use ($gn) {
                    return $a['Group_name'] == $gn;
                });
                $interMult = array_filter($inmultData, function ($a) use ($gn) {
                    return $a['Group_name'] == $gn;
                });
                $interMsg = array_filter($inmsgData, function ($a) use ($gn) {
                    return $a['Group_name'] == $gn;
                });
            }
            if (! in_array($wid, $allnum) && ! Groups::where('whatsapp_id', $wid)->exists()) {
                $allnum[] = $wid;
                $nwGrp = Groups::create([
                    'name' => $gn,
                    'active' => true,
                    'type' => $type,
                    'language' => 'mr',
                    'user_id' => 1,
                    'organization_id' => $grorg,
                    'sync_date' => Carbon::now('Asia/Kolkata'),
                    'whatsapp_id' => $wid == 0 ? null : $wid,
                    'admin_right' => $grp->Admin_Rights,
                    'send_right' => $sndr,
                    'verified' => $wid == 0 ? 0 : 1,
                ]);
                $nwGrp->GroupsNumbers()->attach($ga,
                    ['role' => 'GA', 'admin' => $grp->Admin_Rights, 'added' => 1]);
                if ($grp->Assigned_Vnum != '917657884236') {
                    $nwGrp->GroupsNumbers()->attach($cb[$grp->Assigned_Vnum],
                        ['role' => 'CB', 'admin' => false, 'added' => $sndr]);
                }
                foreach ($moderators as $mod) {
                    $aMod = $AllMod[$mod];
                    if ($aMod->phone == $grp->MainAW_Whatsapp_No) {
                        $nwGrp->GroupsModerators()->attach($aMod->id, ['main' => true, 'added' => 1]);
                    } else {
                        $nwGrp->GroupsModerators()->attach($aMod->id, ['main' => false, 'added' => 1]);
                    }
                }
                if ($type != 'Moderators') {
                    foreach ($pars as $parent) {
                        $prt = Guardian::firstOrCreate(['mother_name' => $parent['mother_name'], 'father_name' => $parent['father_name'],
                            'phone' => $parent['Sender ID']]);
                        $prt->update(['groups_id' => $nwGrp->id]);
                        if ($parent['children'] != '' && ! is_null($parent['children'])) {
                            $kids = explode(',', $parent['children']);
                            foreach ($kids as $kid) {
                                Kid::firstOrCreate([
                                    'name' => $kid,
                                    'guardian_id' => $prt->id,
                                ]);
                            }
                        }
                    }
                }
                if (count($intervene) > 0) {
                    $multid = [];
                    $invid = [];
                    foreach ($intervene as $inv) {
                        $currinv = Intervention::create(['message_text' => $inv['message_text'], 'language' => $nwGrp->language,
                            'user_id' => 1, 'target_group' => 1,
                            'groups_id' => $nwGrp->id, 'direct' => 1, 'intervention_type' => $inv['intervention_type']]);
                        $unid = $inv['uinid'];
                        $invid[$unid] = $currinv->id;
                        $currmult = array_filter($interMult, function ($a) use ($unid) {
                            return $a['uinid'] == $unid;
                        });

                        if (count($currmult) > 0) {
                            foreach ($currmult as $cmult) {
                                $unmuid = $cmult['uimulid'];
                                $loc = $cmult['location'];
                                $dur = null;
                                if ($loc == 'NA' || $loc == '') {
                                    $loc = null;
                                } elseif ($cmult['type'] == 'Video') {
                                    $dur = $cmult['duration'];
                                }
                                $minmult = InterventionMultimedia::create(['location' => $loc, 'type' => $cmult['type'], 'youtube' => $cmult['youtube'],
                                    'intervention_id' => $currinv->id, 'duration' => $dur, 'cloud' => 0]);
                                $multid[$unmuid] = $minmult->id;
                            }
                        }
                        $currmsg = array_filter($interMsg, function ($a) use ($unid) {
                            return $a['uinid'] == $unid;
                        });
                        if (count($currmsg) > 0) {
                            foreach ($currmsg as $cmsg) {
                                $msgmul = null;
                                if ($cmsg['uimulid'] != '') {
                                    if (array_key_exists($cmsg['uimulid'], $multid)) {
                                        $msgmul = $multid[$cmsg['uimulid']];
                                    }
                                }
                                InterventionMessage::create(['sent' => 1, 'delivered' => 1,
                                    'interventions_id' => $currinv->id, 'intervention_multimedia_id' => $msgmul, 'sent_time' => Carbon::parse($cmsg['sent_time']),
                                    'delivery_time' => Carbon::parse($cmsg['delivery_time']), 'retry_count' => 0, 'vnumber' => $cmsg['vnumber']]);
                            }
                        }
                    }
                }
                if (count($modInt) > 0) {
                    foreach ($modInt as $mint) {
                        $nmul = null;
                        $ntxt = null;
                        $nloc = null;
                        $nint = null;
                        $ndur = null;
                        if ($mint['Attachment.type'] != 'Chat') {
                            $nmul = $mint['Attachment.type'];
                            if ($mint['Attachment'] != 'NA' && $mint['Attachment'] != '') {
                                $nloc = $mint['Attachment'];
                                if ($mint['duration'] != 0) {
                                    $ndur = $mint['duration'];
                                }
                            }
                        }
                        if ($mint['Text'] != 'NA' && $mint['Text'] != '') {
                            $ntxt = $mint['Text'];
                        }
                        if ($mint['proxmod'] != '') {
                            if (array_key_exists($mint['proxmod'], $invid)) {
                                $nint = $invid[$mint['proxmod']];
                            }
                        }
                        Interaction::create(['downloaded' => 0, 'interventions_id' => $nint, 'organization_id' => $nwGrp->organization_id,
                            'groups_id' => $nwGrp->id, 'sent_time' => Carbon::parse($mint['Sent.Date']),
                            'multimedia_type' => $nmul, 'multimedia_location' => $nloc,
                            'message_type' => $mint['Attachment.type'], 'moderator_phone' => $mint['Sender.ID'],
                            'from_parent' => 0, 'text' => $ntxt, 'duration' => $ndur]);
                    }
                }
                if (count($parInt) > 0 && $type != 'Moderators') {
                    foreach ($parInt as $pint) {
                        $nmul = null;
                        $ntxt = null;
                        $nloc = null;
                        $nint = null;
                        $ndur = null;
                        if ($pint['Attachment.type'] != 'Chat') {
                            $nmul = $pint['Attachment.type'];
                            if ($pint['Attachment'] != 'NA' && $pint['Attachment'] != '') {
                                $nloc = $pint['Attachment'];
                                if ($pint['duration'] != 0) {
                                    $ndur = $pint['duration'];
                                }
                            }
                        }
                        if ($pint['Text'] != 'NA' && $pint['Text'] != '') {
                            $ntxt = $pint['Text'];
                        }
                        if ($pint['proxpar'] != '') {
                            if (array_key_exists($pint['proxpar'], $invid)) {
                                $nint = $invid[$pint['proxpar']];
                            }
                        }
                        if (in_array($pint['Sender.ID'], array_column($pars, 'Sender ID'))) {
                            Interaction::create(['downloaded' => 0, 'interventions_id' => $nint,
                                'groups_id' => $nwGrp->id, 'sent_time' => Carbon::parse($pint['Sent.Date']),
                                'multimedia_type' => $nmul, 'multimedia_location' => $nloc,
                                'message_type' => $pint['Attachment.type'], 'guardian_phone' => $pint['Sender.ID'],
                                'from_parent' => 1, 'text' => $ntxt, 'duration' => $ndur, 'organization_id' => $nwGrp->organization_id]);
                        }
                    }
                }
            }

        }
    }

    public function ReconcileGroups($ga, $cb)
    {
        $exid = array_unique(array_map(function ($i) {
            return $i['id'];
        }, $ga));
        $res = $ga;
        foreach ($cb as $c) {
            if (in_array($c['id'], $exid)) {
                $cid = $c['id'];
                $mar = array_values(array_filter($res, function ($a) use ($cid) {
                    return $a['id'] == $cid;
                }))[0];
                if ($mar['size'] < $c['size']) {
                    $find = array_key_first($mar);
                    $res[$find] = $c;
                }
            } else {
                array_push($res, $c);
            }
        }

        return $res;
    }

    public function FindGroup($inst, $tk, $url)
    {
        $apistat = false;
        $allgrp = [];
        if (! is_null($inst)) {
            try {
                if (! isset($url)) {
                    $url = 'https://eu135.chat-api.com/';
                }
                $cli = new Client([
                    // Base URI is used with relative requests
                    'base_uri' => $url,
                    // You can set any number of default request options.
                    'timeout' => 2000.0,
                ]);
                $response = $cli->request('GET', '/instance'.$inst.'/dialogs?token='.
                    $tk);
                $code = $response->getStatusCode(); // 200
                if ($code == 200 || $code == 202) {
                    $body = json_decode($response->getBody());
                    $allDialogs = $body->dialogs;
                    $list = [];

                    foreach ($allDialogs as $dialog) {
                        if ($dialog->group == true) {
                            $exclphone = ['17813559759', '17817973225', '917657884236', '17812681369', '17813348880', '17815365029', '17812652010', '917506015410', '917658889936', '919833342362', '18579281333', '919686930879', '919599762582'];
                            $currpart = $dialog->participants;
                            $currphone = [];
                            for ($i = 0; $i < count($currpart); $i++) {
                                $tempphone = preg_split('~@~', $currpart[$i])[0];
                                if (! in_array($tempphone, $exclphone)) {
                                    array_push($currphone, $tempphone);
                                }
                            }
                            array_push($list, ['id' => $dialog->id, 'name' => $dialog->name,
                                'size' => count($currphone), 'participants' => $currphone]);
                        }
                    }
                    $apistat = true;
                    $allgrp = $list;
                }
            } catch (GuzzleException $e) {

            }
        }

        return [$apistat, $allgrp];
    }
}
