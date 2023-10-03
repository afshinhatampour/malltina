<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Models\Product;
use App\Services\Product\AdminCreateProduct;
use App\Services\Product\AdminUpdateProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class ProductController extends ApiController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->success(trans('product.admin.index'), Product::paginate(self::PER_PAGE));
    }

    /**
     * @param StoreProductRequest $request
     * @param AdminCreateProduct $createProduct
     * @return JsonResponse
     */
    public function store(StoreProductRequest $request, AdminCreateProduct $createProduct): JsonResponse
    {
        return $this->success(trans('product.admin.store'),
            $createProduct->do($request->validated()), HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        return $this->success(trans('product.admin.show'), $product);
    }

    /**
     * we can do update functionality in update method as well, but we can use a service for
     * check all conditions and implement all functionality in separate class,
     * so we have a main point when using update service
     * using in other controller and other console commend only by call update product service class
     *
     * @param UpdateProductRequest $request
     * @param Product $product
     * @param AdminUpdateProduct $updateProduct
     * @return JsonResponse
     */
    public function update(UpdateProductRequest $request, Product $product, AdminUpdateProduct $updateProduct): JsonResponse
    {
        return $this->success(trans('product.admin.update'),
            $updateProduct->do($request->validated(), $product));
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->variations()->detach();
        $product->delete();
        return $this->success(trans('product.admin.delete'), [], HttpFoundationResponse::HTTP_NO_CONTENT);
    }
}
