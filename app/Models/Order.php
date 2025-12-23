<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property-read int|string $id
 * @property int|string $user_id
 * @property int|string|null $trip_id
 * @property-read \DateTime $created_at
 * @property-read \DateTime $updated_at
 */
class Order extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<User, Order>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany<Product, Order, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'products_orders', 'order_id', 'product_id');
    }

    /**
     * @return BelongsTo<Trip, Order>
     */
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
}
