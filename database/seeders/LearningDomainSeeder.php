<?php

namespace Database\Seeders;

use App\Models\LearningDomain;
use Illuminate\Database\Seeder;

class LearningDomainSeeder extends Seeder
{
    public function csvToArray($filename = '', $delimiter = ',')
    {
        if (! file_exists($filename) || ! is_readable($filename)) {
            return false;
        }

        $header = ['tag', 'learning_domain', 'subject'];
        $data = [];
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (count($row) == 3) {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        return $data;
    }

    public function csvToArrayd($filename = '', $delimiter = '>')
    {
        if (! file_exists($filename) || ! is_readable($filename)) {
            return false;
        }

        $header = ['sub_domain'];
        $data = [];
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (count($row) == 1) {
                    $data[] = array_combine($header, $row);
                }
                //var_dump($row);
            }
            fclose($handle);
        }

        return $data;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //will add/update records in learning_domains table in db
        $file = public_path('learning_domains.csv');
        $filed = public_path('sub_domains.csv');
        $Arr = $this->csvToArray($file);
        $Arrd = $this->csvToArrayd($filed);
        $db_record = LearningDomain::get()->ToArray();
        $db_record_count = count($db_record);

        $max_record = count($Arr) >= $db_record_count ? count($Arr) : $db_record_count;
        for ($i = 0; $i < $max_record; $i++) {
            if ($i + 1 <= $db_record_count && $i + 1 <= count($Arr)) {
                $l_domain = LearningDomain::find($db_record[$i]['id']);
                if ($Arr[$i]['learning_domain'] != $db_record[$i]['learning_domain']) {
                    $l_domain->learning_domain = $Arr[$i]['learning_domain'];
                }
                if ($Arrd[$i]['sub_domain'] != $db_record[$i]['sub_domain']) {
                    $l_domain->sub_domain = $Arrd[$i]['sub_domain'];
                }
                if (($Arr[$i]['tag'].'_'.($i + 1)) != $db_record[$i]['tag']) {
                    $l_domain->tag = $Arr[$i]['tag'].'_'.($i + 1);
                }
                if ($Arr[$i]['subject'] != $db_record[$i]['subject']) {
                    $l_domain->subject = $Arr[$i]['subject'];
                }
                $l_domain->save();
            } elseif ($i + 1 > $db_record_count) {
                $subdomain = $Arrd[$i]['sub_domain'];
                $tag = $Arr[$i]['tag'].'_'.($i + 1);
                $learning_domain = $Arr[$i]['learning_domain'];
                $subject = $Arr[$i]['subject'];
                LearningDomain::Create(['sub_domain' => $subdomain, 'tag' => $tag, 'learning_domain' => $learning_domain, 'subject' => $subject]);
            } elseif ($i + 1 > count($Arr)) {
                break;
            }
        }
    }
}
