<?php

namespace App\Enums\Api\V1;

enum MessageType: string
{
    case TEXT = 'text';
    case IMAGE = 'image';
    case AUDIO = 'audio';
    case VIDEO = 'video';
    case LOCATION = 'location';
    case CONTACT = 'contact';
    case STICKER = 'sticker';
}
