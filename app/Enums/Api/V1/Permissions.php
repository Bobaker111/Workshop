<?php

namespace App\Enums\Api\V1;

enum Permissions: string
{
    // Accounts
    case LIST_ACCOUNTS = 'list accounts';
    case SHOW_ACCOUNT = 'show account';
    case CREATE_ACCOUNT = 'create account';
    case UPDATE_ACCOUNT = 'update account';
    case DELETE_ACCOUNT = 'delete account';

    // Delivery requests
    case LIST_DELIVERY_REQUESTS = 'list delivery requests';
    case SHOW_DELIVERY_REQUEST = 'show delivery request';
    case CREATE_DELIVERY_REQUEST = 'create delivery request';
    case UPDATE_DELIVERY_REQUEST = 'update delivery request';
    case DELETE_DELIVERY_REQUEST = 'delete delivery request';

    // Products
    case LIST_PRODUCTS = 'list products';
    case SHOW_PRODUCT = 'show product';
    case CREATE_PRODUCT = 'create product';
    case UPDATE_PRODUCT = 'update product';
    case DELETE_PRODUCT = 'delete product';

    // Categories
    case LIST_CATEGORIES = 'list categories';
    case SHOW_CATEGORY = 'show category';
    case CREATE_CATEGORY = 'create category';
    case UPDATE_CATEGORY = 'update category';
    case DELETE_CATEGORY = 'delete category';

    // Deals
    case LIST_DEALS = 'list deals';
    case SHOW_DEAL = 'show deal';
    case CREATE_DEAL = 'create deal';
    case UPDATE_DEAL = 'update deal';
    case DELETE_DEAL = 'delete deal';

    // Trips
    case LIST_TRIPS = 'list trips';
    case SHOW_TRIP = 'show trip';
    case CREATE_TRIP = 'create trip';
    case UPDATE_TRIP = 'update trip';
    case DELETE_TRIP = 'delete trip';

    // Orders
    case LIST_ORDERS = 'list orders';
    case SHOW_ORDER = 'show order';
    case CREATE_ORDER = 'create order';
    case UPDATE_ORDER = 'update order';
    case DELETE_ORDER = 'delete order';

    // Shops
    case LIST_SHOPS = 'list shops';
    case SHOW_SHOP = 'show shop';
    case CREATE_SHOP = 'create shop';
    case UPDATE_SHOP = 'update shop';
    case DELETE_SHOP = 'delete shop';

    // Disputes
    case LIST_DISPUTES = 'list disputes';
    case SHOW_DISPUTE = 'show dispute';
    case CREATE_DISPUTES = 'create disputes';
    case UPDATE_DISPUTES = 'update disputes';
    case DELETE_DISPUTES = 'delete disputes';

    // Ratings
    case LIST_RATINGS = 'list ratings';
    case SHOW_RATING = 'show rating';
    case CREATE_RATING = 'create rating';
    case UPDATE_RATING = 'update rating';
    case DELETE_RATING = 'delete rating';

    // Analytics and reporting
    case VIEW_ANALYTICS = 'view analytics';
    case GENERATE_ANALYTICS_REPORTS = 'generate analytics reports';

    // Notifications
    case LIST_NOTIFICATIONS = 'list notifications';
    case SHOW_NOTIFICATION = 'show notification';
    case CREATE_NOTIFICATIONS = 'create notifications';
    case UPDATE_NOTIFICATIONS = 'update notifications';
    case DELETE_NOTIFICATIONS = 'delete notifications';

    // Messaging
    case LIST_MESSAGES = 'list messages';
    case EXCHANGE_MESSAGES = 'exchange messages';

    // Uploads
    case UPLOAD_FILES = 'upload files';

    // Financials
    case VIEW_FINANCIAL_REPORTS = 'view financial reports';
    case GENERATE_FINANCIAL_REPORTS = 'generate financial reports';

    // Content
    case UPDATE_TERMS_OF_SERVICE = 'update terms of service';
    case UPDATE_PRIVACY_POLICY = 'update privacy policy';

    public static function storeOwnerPermissions(): array
    {
        return [
            self::SHOW_ACCOUNT,
            self::UPDATE_ACCOUNT,
            self::DELETE_ACCOUNT,

            self::LIST_PRODUCTS,
            self::SHOW_PRODUCT,
            self::CREATE_PRODUCT,
            self::UPDATE_PRODUCT,
            self::DELETE_PRODUCT,

            self::LIST_CATEGORIES,
            self::SHOW_CATEGORY,

            self::LIST_SHOPS,
            self::SHOW_SHOP,

            self::LIST_TRIPS,
            self::SHOW_TRIP,
            self::CREATE_TRIP,
            self::UPDATE_TRIP,
            self::DELETE_TRIP,

            self::LIST_DELIVERY_REQUESTS,
            self::SHOW_DELIVERY_REQUEST,
            self::CREATE_DELIVERY_REQUEST,
            self::UPDATE_DELIVERY_REQUEST,
            self::DELETE_DELIVERY_REQUEST,

            self::LIST_DEALS,
            self::SHOW_DEAL,
            self::CREATE_DEAL,
            self::UPDATE_DEAL,
            self::DELETE_DEAL,

            self::LIST_ORDERS,
            self::SHOW_ORDER,
            self::CREATE_ORDER,
            self::UPDATE_ORDER,
            self::DELETE_ORDER,

            self::EXCHANGE_MESSAGES,

            self::SHOW_NOTIFICATION,

            self::VIEW_ANALYTICS,
            self::GENERATE_ANALYTICS_REPORTS,

            self::VIEW_FINANCIAL_REPORTS,
            self::GENERATE_FINANCIAL_REPORTS,

            self::UPLOAD_FILES,
        ];
    }

    /**
     * @return array<Permissions>
     */
    public static function workshopOwnerPermissions(): array
    {
        return [
            self::SHOW_ACCOUNT,
            self::UPDATE_ACCOUNT,
            self::DELETE_ACCOUNT,

            self::LIST_DELIVERY_REQUESTS,
            self::SHOW_DELIVERY_REQUEST,
            self::CREATE_DELIVERY_REQUEST,
            self::UPDATE_DELIVERY_REQUEST,
            self::DELETE_DELIVERY_REQUEST,

            self::EXCHANGE_MESSAGES,

            self::SHOW_NOTIFICATION,

            self::VIEW_ANALYTICS,
            self::GENERATE_ANALYTICS_REPORTS,

            self::VIEW_FINANCIAL_REPORTS,
            self::GENERATE_FINANCIAL_REPORTS,

            self::UPLOAD_FILES,
        ];
    }

    /**
     * @return array<Permissions>
     */
    public static function driverPermissions(): array
    {
        return [
            self::SHOW_ACCOUNT,
            self::UPDATE_ACCOUNT,

            self::LIST_DELIVERY_REQUESTS,
            self::SHOW_DELIVERY_REQUEST,
            self::UPDATE_DELIVERY_REQUEST,

            self::LIST_PRODUCTS,
            self::SHOW_PRODUCT,

            self::LIST_ORDERS,
            self::SHOW_ORDER,

            self::EXCHANGE_MESSAGES,

            self::SHOW_NOTIFICATION,

            self::VIEW_ANALYTICS,
            self::GENERATE_ANALYTICS_REPORTS,

            self::VIEW_FINANCIAL_REPORTS,
            self::GENERATE_FINANCIAL_REPORTS,

            self::UPLOAD_FILES,
        ];
    }

    /**
     * @return array<Permissions>
     */
    public static function customerPermissions(): array
    {
        return [
            self::SHOW_ACCOUNT,
            self::UPDATE_ACCOUNT,
            self::DELETE_ACCOUNT,

            self::LIST_ORDERS,
            self::SHOW_ORDER,
            self::CREATE_ORDER,
            self::UPDATE_ORDER,
            self::DELETE_ORDER,

            self::LIST_PRODUCTS,
            self::SHOW_PRODUCT,

            self::SHOW_NOTIFICATION,

            self::EXCHANGE_MESSAGES,

            self::LIST_RATINGS,
            self::SHOW_RATING,
            self::CREATE_RATING,
            self::UPDATE_RATING,
            self::DELETE_RATING,
        ];
    }

    /**
     * @return array<Permissions>
     */
    public static function superAdminPermissions(): array
    {
        return self::cases();
    }
}
