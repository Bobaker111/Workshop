<?php

namespace App\Http\Controllers\Api\V1\Categories;

use App\Enums\Http\HttpStatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Categories\CreateCategoryRequest;
use App\Http\Requests\Api\V1\Categories\DeleteCategoryRequest;
use App\Http\Requests\Api\V1\Categories\ListCategoriesRequest;
use App\Http\Requests\Api\V1\Categories\ShowCategoryRequest;
use App\Http\Requests\Api\V1\Categories\UpdateCategoryRequest;
use App\Http\Resources\Api\V1\Categories\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index(ListCategoriesRequest $request): ResourceCollection
    {
        // TODO: add filtering
        $categories = Category::where('category_id', null)
            ->with('children')
            ->simplePaginate($request->input('per_page', 25));

        return CategoryResource::collection($categories);
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show(ShowCategoryRequest $request, Category $category): JsonResource
    {
        return new CategoryResource($category);
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request): JsonResource
    {
        $category = Category::create($request->validated());

        return new CategoryResource($category);
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category): JsonResource
    {
        $category->fill($request->validated());
        $category->save();

        return new CategoryResource($category);
    }

    public function delete(DeleteCategoryRequest $request, Category $category): Response
    {
        $category->delete();

        return $this->success(code: HttpStatusCode::NO_CONTENT);
    }
}
