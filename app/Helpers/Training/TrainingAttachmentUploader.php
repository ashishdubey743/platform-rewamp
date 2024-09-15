<?php

namespace App\Helpers\Training;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TrainingAttachmentUploader
{
    private static string $logoSuffix = '_logo';

    private static string $certificateSuffix = '_certificate';

    /**
     * Upload training certificates to S3 Bucket.
     */
    public static function certificate(int $training_id, UploadedFile $file, string $language, ?string $existing = null): false|string
    {
        // Remove old attachment from S3 Bucket
        if ($existing) {
            self::deleteAttachment($existing, self::certificateUploadPath());
        }

        // Upload to S3 Bucket
        $certificate_name = Str::finish($training_id.self::$certificateSuffix.'_'.$language, '.'.$file->extension());

        return self::uploadAttachment($certificate_name, $file->path(), self::certificateUploadPath());
    }

    /**
     * Upload training certificates to S3 Bucket.
     */
    public static function logo(int $training_id, UploadedFile $file, ?string $existing = null): false|string
    {
        // Remove old attachment from S3 Bucket
        if ($existing) {
            self::deleteAttachment($existing, self::logoUploadPath());
        }

        // Upload to S3 Bucket
        $logo_name = Str::finish($training_id.self::$logoSuffix, '.'.$file->extension());

        return self::uploadAttachment($logo_name, $file->path(), self::logoUploadPath());
    }

    /**
     * Upload an attachment
     */
    private static function uploadAttachment(string $name, string $fileContent, string $path): false|string
    {
        try {
            $content = fopen($fileContent, 'r');
            $path = $path.'/'.$name;
            Storage::disk('s3')->put($path, $content);

            return $name;
        } catch (Exception $ex) {
            $errorRecord = ['file' => $ex->getFile(), 'line_no' => $ex->getLine()];
            Log::warning($ex->getMessage(), $errorRecord);

            return false;
        }
    }

    /**
     * Delete an attachment
     */
    private static function deleteAttachment(string $name, string $path): bool
    {
        try {
            $path = $path.'/'.$name;
            Storage::disk('s3')->delete($path);

            return true;
        } catch (Exception $ex) {
            $errorRecord = ['file' => $ex->getFile(), 'line_no' => $ex->getLine()];
            Log::warning($ex->getMessage(), $errorRecord);

            return false;
        }
    }

    // Attachment Upload locations

    /**
     * Certificate upload path
     */
    private static function certificateUploadPath(): string
    {
        return 'questionnaire-training/'.(config('app.env') === 'development' ? 'test/' : '').'certificates';
    }

    /**
     * Logo upload path
     */
    private static function logoUploadPath(): string
    {
        return 'questionnaire-training/'.(config('app.env') === 'development' ? 'test/' : '').'logo';
    }
}
