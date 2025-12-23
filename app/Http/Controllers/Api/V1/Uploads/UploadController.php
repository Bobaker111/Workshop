<?php

namespace App\Http\Controllers\Api\V1\Uploads;

use App\Enums\Http\HttpStatusCode;
use App\Exceptions\InvalidUploadOperationException;
use App\Exceptions\MediaCapableResourceNotFound;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Uploads\AuthorizeUploadOperationRequest;
use App\Http\Requests\Api\V1\Uploads\UploadRequest;
use App\Http\Requests\DeleteMediaRequest;
use App\Http\Resources\MediaResource;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class UploadController extends Controller
{
    public function __construct(protected MediaService $mediaService) {}

    public function authorize(AuthorizeUploadOperationRequest $request): string|JsonResponse
    {
        try {
            return $this->success($this->mediaService->initializeUpload($request->all()));
        } catch (MediaCapableResourceNotFound $e) {
            return $this->error($e->getMessage(), HttpStatusCode::NOT_FOUND);
        }
    }

    public function upload(UploadRequest $request): JsonResource|JsonResponse
    {
        try {
            $files = $request->allFiles()['files'] ?? [];

            if (! is_array($files)) {
                $files = [$files];
            }

            $media = $this->mediaService->upload(
                $request->query('id'),
                $files,
                $request->user()->id
            );

            if (is_null($media)) {
                return $this->error('Invalid file type. Only jpg, jpeg, png, mp3, mp4, mkv, wav files are allowed.');
            }

            if (is_array($media)) {
                return MediaResource::collection($media);
            }

            return MediaResource::collection([$media]);
        } catch (InvalidUploadOperationException $e) {
            return $this->error($e->getMessage());
        }
    }

    public function delete(DeleteMediaRequest $request): JsonResponse
    {
        $this->mediaService->deleteMedia($request->input('media'));

        return $this->success(code: 204);
    }
}
