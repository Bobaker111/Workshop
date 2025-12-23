<?php

namespace App\Http\Controllers\Api\V1\Trips;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Trip\StoreTripRequest;
use App\Http\Requests\Api\V1\Trip\UpdateTripRequest;
use App\Http\Resources\Api\V1\TripResource;
use App\Models\Trip;

class TripController extends Controller
{
    // TODO: add filter and search
    public function index()
    {
        return TripResource::collection(Trip::simplePaginate());
    }

    /**
     * Show a single trip information
     *
     * @return TripResource
     */
    public function show(Trip $trip)
    {
        return new TripResource($trip);
    }

    /**
     * Create a new trip
     *
     * @return TripResource
     */
    public function store(StoreTripRequest $request)
    {
        // Transporters start the trip.
        $trip = Trip::create($request->validated());

        return new TripResource($trip);
    }

    /**
     * Update a trip
     *
     * @return TripResource
     */
    public function update(UpdateTripRequest $request, Trip $trip)
    {
        $trip->update($request->validated());

        return new TripResource($trip);
    }

    /**
     * Get tracking information for a trip
     *
     * @return TripResource
     */
    public function track(Trip $trip)
    {
        return new TripResource($trip->getTrackingInformation());
    }
}
