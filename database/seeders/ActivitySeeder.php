<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\ActivityMultimedia;
use App\Models\LearningDomain;
use Illuminate\Database\Seeder;
// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class ActivitySeeder extends Seeder
{
//     public function csvToArray($filename = '', $delimiter = ',')
//     {
//         if (! file_exists($filename) || ! is_readable($filename)) {
//             return false;
//         }

//         $header = ['tag', 'learning_domain'];
//         $data = [];
//         if (($handle = fopen($filename, 'r')) !== false) {
//             while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {

//                 if (count($row) == 2) {
//                     $data[] = array_combine($header, $row);

//                 }
//             }
//             fclose($handle);
//         }

//         return $data;
//     }

//     public function csvToArrayd($filename = '', $delimiter = '>')
//     {
//         if (! file_exists($filename) || ! is_readable($filename)) {
//             return false;
//         }

//         $header = ['sub_domain'];
//         $data = [];
//         if (($handle = fopen($filename, 'r')) !== false) {
//             while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
//                 if (count($row) == 1) {
//                     $data[] = array_combine($header, $row);
//                 }
//                 //var_dump($row);
//             }
//             fclose($handle);
//         }

//         return $data;
//     }

//     public function csvToArrayact($filename = '', $delimiter = ',')
//     {
//         if (! file_exists($filename) || ! is_readable($filename)) {
//             return false;
//         }

//         $header = ['title', 'difficulty_level', 'multimedia_location', 'activity_description', 'language', 'external_source', 'sub_domains', 'response_type', 'multimedia_type', 'impact_timeline', 'group_size', 'audience', 'required_materials', 'internal', 'activity_type', 'demo_type'];
//         $data = [];
//         if (($handle = fopen($filename, 'r')) !== false) {
//             while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
//                 $data[] = array_combine($header, $row);
//             }
//             fclose($handle);
//         }

//         return $data;
//     }

    public function run(): void
    {
        // $file = public_path('learning_domains.csv');
        // $filed = public_path('sub_domains.csv');
        // $Arr = $this->csvToArray($file);
        // $Arrd = $this->csvToArrayd($filed);
        // for ($i = 0; $i < count($Arr); $i++) {
        //     $subdomain = $Arrd[$i]['sub_domain'];
        //     $tag = $Arr[$i]['tag'].'_'.($i + 1);
        //     $learning_domain = $Arr[$i]['learning_domain'];
        //     //var_dump($subdomain,$learning_domain,  $tag);
        //     LearningDomain::Create(['sub_domain' => $subdomain, 'tag' => $tag, 'learning_domain' => $learning_domain]);
        // }
        // $file = public_path('activities.csv');
        // $Arr = $this->csvToArrayact($file);
        // //        $langs[]=array(
        // //            ["code" =>"hi","name"=>"Hindi","nativeName"=>"हिन्दी, हिंदी"],
        // //        ["code"=>"as","name"=>"Assamese","nativeName"=>"অসমীয়া"],
        // //        ["code"=>"bn","name"=>"Bengali","nativeName"=>"বাংলা"],
        // //        ["code"=>"bh","name"=>"Bihari","nativeName"=>"भोजपुरी"],
        // //        ["code"=>"gu","name"=>"Gujarati","nativeName"=>"ગુજરાતી"],
        // //        ["code"=>"kn","name"=>"Kannada","nativeName"=>"ಕನ್ನಡ"],
        // //        ["code"=>"ks","name"=>"Kashmiri","nativeName"=>" كشميري‎"],
        // //        ["code"=>"ku","name"=>"Kurdish","nativeName"=>" كوردی‎"],
        // //        ["code"=>"ml","name"=>"Malayalam","nativeName"=>"മലയാളം"],
        // //        ["code"=>"mr","name"=>"Marathi ","nativeName"=>"मराठी"],
        // //        ["code"=>"ne","name"=>"Nepali","nativeName"=>"नेपाली"],
        // //        ["code"=>"or","name"=>"Oriya","nativeName"=>"ଓଡ଼ିଆ"],
        // //        ["code"=>"pa","name"=>"Punjabi","nativeName"=>"ਪੰਜਾਬੀ‎"],
        // //        ["code"=>"pi","name"=>"Pāli","nativeName"=>"पाऴि"],
        // //        ["code"=>"sd","name"=>"Sindhi","nativeName"=>"सिन्धी"],
        // //        ["code"=>"si","name"=>"Sinhala, Sinhalese","nativeName"=>"සිංහල"],
        // //        ["code"=>"ta","name"=>"Tamil","nativeName"=>"தமிழ்"],
        // //        ["code"=>"te","name"=>"Telugu","nativeName"=>"తెలుగు"],
        // //        ["code"=>"ur","name"=>"Urdu","nativeName"=>"اردو"],
        // //        ["code"=>"en","name"=>"English","nativeName"=>"English"]
        // //    );
        // for ($i = 1; $i < count($Arr); $i++) {

        //     $activity = Activity::create(['title' => $Arr[$i]['title'], 'activity_description' => $Arr[$i]['activity_description'],
        //         'activity_type' => $Arr[$i]['activity_type'], 'demo_type' => $Arr[$i]['demo_type'], 'difficulty_level' => $Arr[$i]['difficulty_level'], 'impact_timeline' => $Arr[$i]['impact_timeline'],
        //         'group_size' => $Arr[$i]['group_size'], 'audience' => $Arr[$i]['audience'], 'required_materials' => $Arr[$i]['required_materials'], 'response_type' => $Arr[$i]['response_type']]);

        //     $sub_domains = explode("','", trim($Arr[$i]['sub_domains'], '"'));
        //     for ($s = 0; $s < count($sub_domains); $s++) {
        //         //                var_dump(trim($sub_domains[$s],"'"));
        //         $learndom = LearningDomain::where('sub_domain', trim($sub_domains[$s], "'"))->first();
        //         $activity->LearningDomain()->attach($learndom);
        //     }
        //     $multimedia_locations = explode("','", trim($Arr[$i]['multimedia_location'], '"'));
        //     for ($m = 0; $m < count($multimedia_locations); $m++) {
        //         $mult = trim($multimedia_locations[$m], "'");
        //         if ($Arr[$i]['internal'] == 'Yes') {
        //             $mult = $mult.'.mp4';
        //         }
        //         ActivityMultimedia::create(['multimedia_location' => $mult, 'type' => $Arr[$i]['multimedia_type'],
        //             'internal' => $Arr[$i]['internal'], 'language' => 'hi', 'activity_id' => $activity->id,
        //             'subscript_location' => '', 'mime_type' => 'video/mp4']);
        //     }
        }

//     }
}
