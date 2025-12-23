<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int|string $id
 * @property int|string $user_id
 * @property string $title
 * @property string $body
 * @property string $destination
 * @property bool $is_read
 * @property-read \DateTime $created_at
 * @property-read \DateTime $updated_at
 * @property-read \DateTime $deleted_at
 */
class Notification extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @return BelongsTo<User, Notification>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
