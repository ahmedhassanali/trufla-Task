<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Services\ProductService;
use App\Traits\ApiResponser;

class ProductController extends Controller
{
    use ApiResponser;

    public function __construct(private ProductService $productService)
    {
        
    }
    public function index()
    {
        try {
            $products = $this->productService->getAll();
            return $this->successResponse($products,'All Products');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
    public function store(ProductStoreRequest $request)
    { 
        try {
            $product = $this->productService->store($request->all());
            return $this->successResponse($product,'Product_saved_successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
    public function update(ProductUpdateRequest $request, Product $product)
    {
        try {
            $product = $this->productService->update($request->all() ,$product->id);
            return $this->successResponse($product,'Product_Updated_successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
    public function show(Product $product)
    {
        try {
            $product = $this->productService->find($product->id);
            return $this->successResponse($product,'success');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
    public function destroy(Product $product)
    {
        try {
            $this->productService->delete($product->id);
            return $this->successResponse("",'Product_Deleted_successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}
