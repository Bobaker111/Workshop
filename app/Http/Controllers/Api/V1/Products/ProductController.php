<?php

namespace App\Http\Controllers\Api\V1\Products;

use App\Enums\Http\HttpStatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Products\CreateProductRequest;
use App\Http\Requests\Api\V1\Products\DeleteProductRequest;
use App\Http\Requests\Api\V1\Products\ListProductsRequest;
use App\Http\Requests\Api\V1\Products\ShowProductRequest;
use App\Http\Requests\Api\V1\Products\UpdateProductRequest;
use App\Http\Resources\Api\V1\Products\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ListProductsRequest $request)
    {
        // TODO: apply filters
        return ProductResource::collection(Product::paginate($request->input('per_page', 25)));
    }

    /**
     * @return ProductResource
     */
    public function show(ShowProductRequest $request, Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * @return ProductResource
     */
    public function store(CreateProductRequest $request)
    {
        $product = $request->user()->products()->create($request->validated());

        return new ProductResource($product);
    }

    /**
     * @return ProductResource
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->fill($request->validated());
        $product->save();

        return new ProductResource($product);
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function delete(DeleteProductRequest $request, Product $product)
    {
        $product->delete();

        return $this->success(code: HttpStatusCode::NO_CONTENT);
    }
}
