<?php

namespace App\Http\Controllers\Api\V1\Analytics;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Analytics\ShowAnalyticsRequest;

class AnalyticsController extends Controller
{
    public function __invoke(ShowAnalyticsRequest $request) {}
}
