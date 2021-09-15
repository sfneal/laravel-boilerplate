<?php

/*
|--------------------------------------------------------------------------
| File upload/download related functions
|--------------------------------------------------------------------------
|
| Here are functions related to file uploading and downloading.  Functions
| are being optimized for S3 file storage as well as local storage.
|
*/

use Illuminate\Support\Facades\Storage;
use Sfneal\Helpers\Aws\S3\StorageS3;

// TODO: refactor these method

// Retrieve an images thumbnail from local or S3 storage
function getImageFile($file, $image_size = null, $return_url = false, $extension = null)
{
    $file_parts = explode('.', $file);
    $fileNameBody = $file_parts[0];
    $fileNameExt = (empty($extension) ? end($file_parts) : $extension);

    if (! empty($image_size)) {
        $file = $fileNameBody.'-'.$image_size.'.'.$fileNameExt;
        if (Storage::disk('s3')->exists($fileNameBody.'-'.$image_size.'.'.strtolower($fileNameExt))) {
            $file = $fileNameBody.'-'.$image_size.'.'.$fileNameExt;
        }
    } else {
        $file = $fileNameBody.'.'.$fileNameExt;
    }

    if ($return_url) {
        return StorageS3::key($file)->urlTemp();
    } else {
        return $file;
    }
}

function imgPath($path, $asset = true)
{
    return (! $asset) ? public_path("assets/$path") : asset("assets/$path");
}

/**
 * Retrieve an array of paths within a directory.
 *
 * @param $dir
 * @return array
 */
function dirToArray($dir)
{
    $result = [];
    $scanned_dir = scandir($dir);
    foreach ($scanned_dir as $key => $value) {
        if (! in_array($value, ['.', '..'])) {
            if (is_dir($dir.DIRECTORY_SEPARATOR.$value)) {
                $result[$value] = dirToArray($dir.DIRECTORY_SEPARATOR.$value);
            } else {
                $result[] = $value;
            }
        }
    }

    return $result;
}
