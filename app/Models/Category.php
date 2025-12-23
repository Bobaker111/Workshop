<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int|string $id
 * @property string $name
 * @property string $description
 * @property string $icon_class
 * @property Category $category
 * @property-read string $created_at
 * @property-read string $updated_at
 * @property-read string $deleted_at
 */
class Category extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * @return HasMany<Product, Category>
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return BelongsTo<Category, Category>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * @return HasMany<Category, Category>
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'category_id');
    }
}
