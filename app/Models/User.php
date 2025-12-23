<?php

namespace App\Models;

use App\Casts\Geography\Point;
use App\Enums\Api\V1\Roles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property string $name
 * @property string $email
 * @property string $phone_number
 * @property string $password
 * @property Roles $role
 * @property Point $address
 * @property string $remember_token
 * @property string $email_verified_at
 * @property-read string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'role' => Roles::class,
            'address' => Point::class,
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * @return HasMany<Trip, User>
     */
    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    /**
     * @return HasMany<Message, User>
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * @return HasMany<Order, User>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return HasMany<Dispute, User>
     */
    public function disputes(): HasMany
    {
        return $this->hasMany(Dispute::class);
    }

    /**
     * @return HasMany<Notification, User>
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * @return HasMany<Product, User>
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'store_id');
    }

    /**
     * @return HasMany<Location, User>
     */
    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    public function currentLocation(): ?Location
    {
        return $this->locations()->latest()->first();
    }

    public function hasAccessToConversation(Conversation $conversation): bool
    {
        return false; // TODO: Implement hasAccessToConversation() method.
    }

    public function isCustomer(): bool
    {
        return $this->hasRole(Roles::CUSTOMER);
    }

    public function isDriver(): bool
    {
        return $this->hasRole(Roles::DRIVER);
    }

    public function isWorkshopOwner(): bool
    {
        return $this->hasRole(Roles::WORKSHOP_OWNER);
    }

    public function isStoreOwner(): bool
    {
        return $this->hasRole(Roles::STORE_OWNER);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(Roles::SUPER_ADMIN);
    }
}
