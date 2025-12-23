<?php

namespace App\Enums\Api\V1;

enum UploadTypes: string
{
    case IMAGE = 'image';
    case VIDEO = 'video';
    case AUDIO = 'audio';
    case UNKNOWN = 'unknown';
}
