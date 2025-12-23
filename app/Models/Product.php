<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property-read int|string $id
 * @property-read int|string $store_id
 * @property string $name
 * @property string|null $description
 * @property float|null $weight
 * @property float $height
 * @property float $width
 * @property-read \DateTime $created_at
 * @property-read \DateTime $updated_at
 * @property-read Category $category
 * @property-read User $store
 * @property-read array<Order> $orders
 */
class Product extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo<User, Product>
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(User::class, 'store_id');
    }

    /**
     * @return BelongsTo<Category, Product>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsToMany<Order, Product, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'products_orders', 'product_id', 'order_id');
    }
}
