<?php

namespace App\Enums\Api\V1;

use App\Models\Category;
use App\Models\Conversation;
use App\Models\Dispute;
use App\Models\Product;
use App\Models\User;

enum UploadCapableType: string
{
    case CONVERSATION = Conversation::class;
    case CATEGORY = Category::class;
    case DISPUTE = Dispute::class;
    case PRODUCT = Product::class;
    case USER = User::class;
}
