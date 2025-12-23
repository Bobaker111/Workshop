<?php

namespace App\Enums\Api\V1;

enum Roles: string
{
    case SUPER_ADMIN = 'super-admin';
    case STORE_OWNER = 'store-owner';
    case WORKSHOP_OWNER = 'workshop-owner';

    case DRIVER = 'driver';
    case CUSTOMER = 'customer';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function permissions(): array
    {
        return match ($this) {
            self::SUPER_ADMIN => Permissions::superAdminPermissions(),
            self::STORE_OWNER => Permissions::storeOwnerPermissions(),
            self::WORKSHOP_OWNER => Permissions::workshopOwnerPermissions(),
            self::DRIVER => Permissions::driverPermissions(),
            self::CUSTOMER => Permissions::customerPermissions(),
        };
    }
}
