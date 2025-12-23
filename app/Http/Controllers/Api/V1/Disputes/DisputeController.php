<?php

namespace App\Http\Controllers\Api\V1\Disputes;

use App\Enums\Http\HttpStatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Disputes\CreateDisputeRequest;
use App\Http\Requests\Api\V1\Disputes\DeleteDisputeRequest;
use App\Http\Requests\Api\V1\Disputes\ListDisputesRequest;
use App\Http\Requests\Api\V1\Disputes\ShowDisputeRequest;
use App\Http\Requests\Api\V1\Disputes\UpdateDisputeRequest;
use App\Http\Resources\Api\V1\Disputes\DisputeResource;
use App\Models\Dispute;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class DisputeController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ListDisputesRequest $request)
    {
        return DisputeResource::collection(Dispute::simplePaginate($request->input('per_page', 25)));
    }

    public function show(ShowDisputeRequest $request, Dispute $dispute): JsonResource
    {
        return new DisputeResource($dispute);
    }

    /**
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(CreatedisputeRequest $request)
    {
        $dispute = $request->user()->disputes()->create($request->validated());

        return new DisputeResource($dispute);
    }

    public function update(UpdateDisputeRequest $request, Dispute $dispute): JsonResource
    {
        $dispute->fill($request->validated());
        $dispute->save();

        return new DisputeResource($dispute);
    }

    public function delete(DeleteDisputeRequest $request, Dispute $dispute): Response
    {
        $dispute->delete();

        return $this->success(code: HttpStatusCode::NO_CONTENT);
    }
}
