<?php

namespace App\Helpers\File;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\SimpleExcel\SimpleExcelReader;
use Spatie\TemporaryDirectory\TemporaryDirectory;

class ExcelHelper
{
    /**
     * Use this function to read data from a remotely stored Excel file.
     *
     * @param string $s3FileLink The path of the file stored in the S3 bucket only works for Excel files.
     * @param int | null $sheetIndex Specify sheet index for multi-sheet Excel.
     * @return array Returns the data in the Excel in an array format.
     */
    public static function getExcelDataFromRemoteStorage(string $s3FileLink, ?int $sheetIndex = null): array
    {
        $temporaryDirectory = (new TemporaryDirectory())->create();

        $path = $temporaryDirectory->path(Str::uuid().'.xlsx');
        File::put($path, file_get_contents($s3FileLink));

        $simpleExcelReader = SimpleExcelReader::create($path, 'xlsx');
        if ($sheetIndex !== null) {
            $rows = $simpleExcelReader
                ->fromSheet($sheetIndex)
                ->getRows()
                ->toArray();
        } else {
            $rows = $simpleExcelReader
                ->getRows()
                ->toArray();
        }

        $simpleExcelReader->close();

        $temporaryDirectory->delete();

        return $rows;
    }
}
