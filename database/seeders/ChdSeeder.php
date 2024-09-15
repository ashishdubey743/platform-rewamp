<?php

namespace Database\Seeders;

use App\Models\Groups;
use App\Models\Guardian;
use App\Models\Interaction;
use App\Models\Intervention;
use App\Models\InterventionMessage;
use App\Models\InterventionMultimedia;
use App\Models\Moderator;
use App\Models\Organization;
use App\Models\VNumbers;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Seeder;

class ChdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ga = VNumbers::create([
            'vnumber' => '917658889936',
            'type' => 'GA',
            'initialize' => '1',
            'API_Token' => 'ihn0jx33qytxt7ji',
            'API_InstanceID' => '144956',
            'API_Url' => 'https://eu200.chat-api.com',
        ]);
        $cb = VNumbers::create([
            'vnumber' => '17812652010',
            'type' => 'CB',
            'initialize' => '1',
            'API_Token' => '1nk4l17fw34c3vxj',
            'API_InstanceID' => '146949',
            'API_Url' => 'https://eu200.chat-api.com',
        ]);
        $org2 = [
            'name' => 'Chandigarh Pre-Schools- Mission Neev', 'active' => 1, 'start_date' => Carbon::parse('2020-07-06', 'Asia/Kolkata'), 'institution_type' => 'UPS',
            'moderator_type' => 'TC', 'state' => 'Chandigarh', 'district' => 'Chandigarh'];
        $org1 = [
            'name' => 'Chandigarh Smart Anganwadi', 'active' => 1, 'start_date' => Carbon::parse('2020-07-07', 'Asia/Kolkata'), 'institution_type' => 'UDC',
            'moderator_type' => 'AW', 'state' => 'Chandigarh', 'district' => 'Chandigarh'];
        $nwOrg1 = Organization::create($org1);
        $nwOrg1->NumbersAssociated()->attach($ga->vnumber,
            ['role' => 'GA']);

        $nwOrg1->NumbersAssociated()->attach($cb->vnumber,
            ['role' => 'CB']);
        $nwOrg2 = Organization::create($org2);
        $nwOrg2->NumbersAssociated()->attach($ga->vnumber,
            ['role' => 'GA']);

        $nwOrg2->NumbersAssociated()->attach($cb->vnumber,
            ['role' => 'CB']);
        $groupData = file_get_contents('http://phonebackups.blob.core.windows.net/seederdata/Chandigarh/7_28_Chd_Group_Anlaysis.json');
        $groupData = json_decode($groupData, false);
        $parentData = file_get_contents('http://phonebackups.blob.core.windows.net/seederdata/Chandigarh/7_28_Chd_Import_Parents.json');
        $parentData = json_decode($parentData, true);
        $modData = file_get_contents('http://phonebackups.blob.core.windows.net/seederdata/Chandigarh/7_28_Chd_Import_Moderators.json');
        $modData = json_decode($modData, true);
        $modIntData = file_get_contents('http://phonebackups.blob.core.windows.net/seederdata/Chandigarh/7_28_Chd_Import_Moderator_Interactions.json');
        $modIntData = json_decode($modIntData, true);
        $parIntData = file_get_contents('http://phonebackups.blob.core.windows.net/seederdata/Chandigarh/7_28_Chd_Import_Parent_Interactions.json');
        $parIntData = json_decode($parIntData, true);
        $intervenData = file_get_contents('http://phonebackups.blob.core.windows.net/seederdata/Chandigarh/7_28_Chd_Import_Interventions.json');
        $intervenData = json_decode($intervenData, true);
        $inmultData = file_get_contents('http://phonebackups.blob.core.windows.net/seederdata/Chandigarh/7_28_Chd_Import_Interventions_Mult.json');
        $inmultData = json_decode($inmultData, true);
        $inmsgData = file_get_contents('http://phonebackups.blob.core.windows.net/seederdata/Chandigarh/7_28_Chd_Import_Interventions_Msg.json');
        $inmsgData = json_decode($inmsgData, true);
        $allMod = array_unique(array_map(function ($i) {
            return $i['Sender ID'];
        }, $modData));
        $allPar = array_unique(array_map(function ($i) {
            return $i['Sender ID'];
        }, $parentData));
        $allnams = [];
        $supergrp = ['Nursery : G10', 'Pre primary curriculum'];
        $resp = $this->FindGroup($ga->API_InstanceID, $ga->API_Token, $ga->API_Url);
        $vresp = $this->FindGroup($cb->API_InstanceID, $cb->API_Token, $cb->API_Url);
        if ($resp[0]) {
            if ($vresp[0]) {
                $allGroups = $this->ReconcileGroups($resp[1], $vresp[1]);
            } else {
                $allGroups = $resp[1];
            }
        } else {
            $allGroups = [];
        }
        //$allGroups=$resp[1];
        $sndr = 0;
        foreach ($groupData as $grp) {
            $gn = $grp->Group_name;
            $wid = '';
            if (! in_array($gn, $supergrp)) {
                $type = 'Parents';
            } else {
                $type = 'Moderators';
            }
            if ($grp->org == 1) {
                $grorg = $nwOrg2->id;
            } else {
                $grorg = $nwOrg1->id;
            }
            $pwn = array_filter($allGroups, function ($a) use ($gn) {
                return ltrim(rtrim($a['name'])) == ltrim(rtrim($gn));
            });
            $pwid = array_map(function ($i) {
                return $i['id'];
            }, $pwn);
            $selwn = [];
            $parpar = [];
            $pars = [];
            $moderators = [];
            $modInt = [];
            $parInt = [];
            $intervene = [];
            $interMult = [];
            $interMsg = [];
            if (count($pwid) > 0) {
                if (count($pwid) == 1) {
                    if (! in_array(array_values($pwid)[0], array_values($allnams))) {
                        $wid = array_values($pwid)[0];
                        $selwn = array_values($pwn)[0];
                        if ($grp->Total_Sent > 0) {
                            $sndr = 1;
                        }
                        $moderators = array_filter($modData, function ($a) use ($gn) {
                            return $a['Chat Session'] == $gn;
                        });
                        $parpar = array_diff($selwn['participants'], $allMod);
                        $parpar = array_diff($parpar, $allPar);
                        $pars = array_filter($parentData, function ($a) use ($gn) {
                            return $a['Chat Session'] == $gn;
                        });
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
                } else {
                    foreach ($pwn as $pw) {
                        if (! in_array($pw['id'], array_values($allnams))) {
                            if (in_array($grp->MainAW_Whatsapp_No, $pw['participants'])) {
                                $selwn = $pw;
                                $wid = $pw['id'];
                                break;
                            } elseif (count($selwn) == 0) {
                                $selwn = $pw;
                                $wid = $pw['id'];
                            }
                        }
                    }
                    $mmod = [$grp->MainAW_Whatsapp_No];
                    if (count($selwn) > 0) {
                        if (in_array($cb->vnumber, $selwn['participants'])) {
                            $sndr = 1;
                        }
                        $pmod = array_intersect($allMod, $selwn['participants']);
                        $pmod = array_unique(array_merge($pmod, $mmod));
                        $moderators = array_filter($modData, function ($a) use ($pmod) {
                            return in_array($a['Sender ID'], $pmod);
                        });
                        $parpar = array_diff($selwn['participants'], $allMod);
                    }
                }
            }
            $allnams[] = $wid;
            $nwGrp = Groups::create([
                'name' => $gn,
                'active' => true,
                'type' => $type,
                'language' => 'hi',
                'user_id' => 1,
                'organization_id' => $grorg,
                'sync_date' => Carbon::now(),
                'whatsapp_id' => $wid == '' ? null : $wid,
                'admin_right' => $grp->Admin_Rights,
                'send_right' => $sndr,
                'verified' => $wid == '' ? 0 : 1,
            ]);
            $nwGrp->GroupsNumbers()->attach($ga,
                ['role' => 'GA', 'admin' => $grp->Admin_Rights, 'added' => 1]);
            $nwGrp->GroupsNumbers()->attach($cb,
                ['role' => 'CB', 'admin' => false, 'added' => $sndr]);
            foreach ($moderators as $mod) {
                $aMod = Moderator::firstOrCreate(['organization_id' => $grorg, 'active' => 1, 'name' => $mod['Sender Name'], 'phone' => $mod['Sender ID']]);
                if ($aMod->phone == $grp->MainAW_Whatsapp_No) {
                    $nwGrp->GroupsModerators()->attach($aMod->id, ['main' => true, 'added' => 1]);
                } else {
                    $nwGrp->GroupsModerators()->attach($aMod->id, ['main' => false, 'added' => 1]);
                }
            }
            if ($type != 'Moderators') {
                foreach ($pars as $parent) {
                    $prt = Guardian::firstOrCreate(['mother_name' => $parent['Sender Name'], 'phone' => $parent['Sender ID']]);
                    $prt->update(['groups_id' => $nwGrp->id]);
                }
                foreach ($parpar as $ppar) {
                    $pprt = Guardian::firstOrCreate(['phone' => $ppar]);
                    $pprt->update(['groups_id' => $nwGrp->id]);
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
                            $nmsg = InterventionMessage::create(['sent' => 1, 'delivered' => 1,
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
                    $cmint = Interaction::create(['downloaded' => 0, 'interventions_id' => $nint, 'organization_id' => $nwGrp->organization_id,
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
                    $cpint = Interaction::create(['downloaded' => 0, 'interventions_id' => $nint,
                        'groups_id' => $nwGrp->id, 'sent_time' => Carbon::parse($pint['Sent.Date']),
                        'multimedia_type' => $nmul, 'multimedia_location' => $nloc,
                        'message_type' => $pint['Attachment.type'], 'guardian_phone' => $pint['Sender.ID'],
                        'from_parent' => 1, 'text' => $ntxt, 'duration' => $ndur, 'organization_id' => $nwGrp->organization_id]);
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
                            $exclphone = ['17813559759', '17817973225', '917657884236', '17812681369', '17813348880', '17815365029', '17812652010', '917506015410',  '917658889936', '919833342362', '18579281333', '919686930879', '919599762582'];
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
