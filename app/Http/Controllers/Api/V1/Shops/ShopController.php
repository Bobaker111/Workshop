<?php

namespace App\Http\Controllers\Api\V1\Shops;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Shop\CreateShopRequest;
use App\Http\Requests\Api\V1\Shop\DeleteShopRequest;
use App\Http\Requests\Api\V1\Shop\ListShopsRequest;
use App\Http\Requests\Api\V1\Shop\ShowShopRequest;
use App\Http\Requests\Api\V1\Shop\UpdateShopRequest;
use App\Models\Shop;

class ShopController extends Controller
{
    public function index(ListShopsRequest $request) {}

    public function show(ShowShopRequest $request, Shop $shop) {}

    public function create(CreateShopRequest $request) {}

    public function update(UpdateShopRequest $request, Shop $shop) {}

    public function delete(DeleteShopRequest $request, Shop $shop) {}
}
