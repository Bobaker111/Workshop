<?php

namespace App\Http\Controllers\Api\V1\Accounts;

use App\Enums\Api\V1\Roles;
use App\Enums\Http\HttpStatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Account\CreateAccountRequest;
use App\Http\Requests\Api\V1\Account\DeleteAccountRequest;
use App\Http\Requests\Api\V1\Account\ListAccountsRequest;
use App\Http\Requests\Api\V1\Account\ShowAccountRequest;
use App\Http\Requests\Api\V1\Account\UpdateAccountRequest;
use App\Http\Requests\Api\V1\Accounts\UpdateLocationRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use Cache;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redis;
use Log;

class AccountController extends Controller
{
    public function index(ListAccountsRequest $request): ResourceCollection
    {
        return UserResource::collection(User::simplePaginate(25));
    }

    public function show(ShowAccountRequest $request, User $account): UserResource
    {
        return new UserResource($account);
    }

    /**
     * Create an account
     *
     * @param CreateAccountRequest $request
     * @return UserResource
     */
    public function store(CreateAccountRequest $request): UserResource
    {
        $data = $request->validated();
        $role = $request->input('role') ?? Roles::CUSTOMER;

        $user = User::create($request->except('role', 'password_confirmation'));
        $user->assignRole($role);

        return new UserResource($user);
    }

    /**
     * Update an account
     *
     * @param UpdateAccountRequest $request
     * @param ?User $account
     * @return UserResource
     */
    public function update(UpdateAccountRequest $request, ?User $account = null): UserResource
    {
        $account->fill($request->validated());
        $account->save();

        return new UserResource($account);
    }

    /**
     * Delete an account
     *
     * @param DeleteAccountRequest $request
     * @param ?User $account
     * @return Response
     */
    public function delete(DeleteAccountRequest $request, ?User $account = null)
    {
        $account?->delete();

        return $this->success(code: HttpStatusCode::NO_CONTENT);
    }

    /**
     * Update the location of the user
     *
     * @param UpdateLocationRequest $request
     * @return Response
     */
    public function updateLocation(UpdateLocationRequest $request): Response
    {
        $user = $request->user();
        foreach ($request->validated() as $point) {
            $user->locations()->create([
                'location' => [
                    'longitude' => $point['longitude'],
                    'latitude' => $point['latitude'],
                ],
            ]);
        }

        $mostRecentLocation = $user->locations()->orderBy('id', 'desc')->first();

        Cache::put(sprintf('user:%d:location', $user->id), [
            'longitude' => $mostRecentLocation['longitude'],
            'latitude' => $mostRecentLocation['latitude'],
        ]);

        return $this->success(code: HttpStatusCode::NO_CONTENT);
    }
}
