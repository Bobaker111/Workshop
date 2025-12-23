<?php

namespace App\Services;

use App\Enums\Api\V1\UploadCapableType;
use App\Enums\Api\V1\UploadTypes;
use App\Exceptions\InvalidUploadOperationException;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    public function initializeUpload(array $data): string
    {

        $data = serialize($data);
        $hash = sha1($data.microtime());
        Cache::set('media-upload-operation:'.$hash, $data);

        return $hash;
    }

    /**
     * @return array<Media>|Media
     *
     * @throws InvalidUploadOperationException
     */
    public function upload(string $operationHash, array $files, string|int $owner): array|Media|null
    {
        $key = 'media-upload-operation:'.$operationHash;
        $data = Cache::get($key);

        if (is_null($data)) {
            throw new InvalidUploadOperationException('Invalid upload operation. Please initialize the upload operation first.');
        }

        $metadata = unserialize($data);

        if (empty($files)) {
            throw new InvalidUploadOperationException('No files provided for upload.');
        }

        $media = ($metadata['entity_type'] == User::class && count($files) == 1)
            ? $this->uploadAvatar($files[0], $metadata, $owner)
            : $this->uploadMultipleFiles($files, $metadata, $owner);

        Cache::forget($key);

        return $media;
    }

    protected function uploadAvatar(UploadedFile $file, array $metadata, string|int $owner): ?Media
    {
        $user = User::find($owner);
        Media::where('upload_capable_id', $user->id)
            ->where('upload_capable_type', User::class)
            ->delete();

        return $this->uploadSingleFile($file, $metadata, $user);
    }

    protected function uploadSingleFile(UploadedFile $file, array $metadata, string|int $owner): ?Media
    {
        $type = $this->getFileMediaTypeFromExtension($file->getClientOriginalExtension());

        if ($type == UploadTypes::UNKNOWN) {
            return null;
        }

        $fileName = sprintf(
            '%s.%s',
            sha1($file->getClientOriginalName()),
            $file->getClientOriginalExtension()
        );

        Storage::disk('media')->putFileAs('', $file, $fileName);

        return Media::create([
            'path' => $fileName,
            'type' => $type,
            'upload_capable_id' => $metadata['entity_id'],
            'upload_capable_type' => UploadCapableType::tryFrom($metadata['entity_type']),
        ]);
    }

    protected function getFileMediaTypeFromExtension(string $extension): UploadTypes
    {
        return match ($extension) {
            'png', 'jpg', 'jpeg' => UploadTypes::IMAGE,
            'mp4', 'mkv', 'wav' => UploadTypes::VIDEO,
            'mp3' => UploadTypes::AUDIO,
            default => UploadTypes::UNKNOWN
        };
    }

    private function uploadMultipleFiles(array $files, array $metadata, string|int $owner): array
    {
        $media = [];
        foreach ($files as $file) {
            $result = $this->uploadSingleFile($file, $metadata, $owner);
            if ($result !== null) {
                $media[] = $result;
            }
        }

        return $media;
    }

    /**
     * @param  array<int>  $mediaIds
     */
    public function deleteMedia(array $mediaIds): bool
    {
        $mediaQuery = Media::whereIn('id', $mediaIds);
        $medias = $mediaQuery->get();
        foreach ($medias as $media) {
            Storage::disk('media')->delete($media->name);
        }

        return $mediaQuery->delete();
    }
}
