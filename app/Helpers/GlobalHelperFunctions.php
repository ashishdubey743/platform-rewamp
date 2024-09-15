<?php

/**
 * Reads static values from a JSON file stored in a public folder.
 *
 * @param  string  $filePath  The path of the file stored in the public folder. Do not put file extensions at the end, like '.json', as the function only takes JSON files.
 * @param  string  $key  The key in the data you are trying to access as a dot notation, for example - 'key.subKey'. Pass an empty string for all data.
 * @param  bool  $asArray  true for array responses and false for JSON data.
 * @return array|string Returns the selected value as a JSON string or array.
 */
if (! function_exists('getJsonData')) {
    function getJsonData($filePath, $key = '', $asArray = true)
    {
        $data = json_decode(File::get(public_path($filePath.'.json')), true);
        if ($key !== '') {
            throw_if(
                ! Arr::has($data, $key),
                'The key was not found in the given file path - '.$filePath
            );
            $data = Arr::get($data, $key);
        }
        if (! $asArray) {
            $data = json_encode($data);
        }

        return $data;
    }
}

/**
 * Validate whether the given string is a date with the provided format or not.
 *
 * @param  string  $string  The date string to validate.
 * @param  string  $format  The date format to validate against. Default is 'Y-m-d'.
 * @return bool Returns true if the string matches the date format, false otherwise.
 */
if (! function_exists('validateDate')) {
    function validateDate($string, $format = 'Y-m-d')
    {
        try {
            $date = Illuminate\Support\Carbon::createFromFormat($format, $string);

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}

if (! function_exists('getMultimediaType')) {
    function getMultimediaType($type)
    {
        $result = null;
        if ($type !== null) {
            $arrType = explode('/', $type);
            if ($arrType[0] === 'video') {
                $result = 'Video';
            } elseif ($arrType[0] === 'image') {
                if ($arrType[1] === 'gif') {
                    $result = 'GIF';
                } else {
                    $result = 'Image';
                }
            } elseif ($arrType[0] === 'text') {
                $result = 'text';
            } elseif ($arrType[0] === 'audio') {
                $result = 'Voice_Note';
            } else {
                $result = 'Other';
            }
        }

        return $result;
    }
}
