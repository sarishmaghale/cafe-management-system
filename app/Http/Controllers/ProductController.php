<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService) {}

    public function show()
    {
        $products = $this->productService->fetchAllProducts();
        return view('display-products', compact('products'));
    }

    public function store(StoreProductRequest $request)
    {
        $products = $request->validated();
        $addedProduct = $this->productService->addNewProduct($products);
        return redirect()->route('products.show')
            ->with('success', 'New product: ' . $addedProduct->product_name . ' added succesfully');
    }

    public function edit(int $id)
    {
        $products = $this->productService->fetchProductById($id);
        return view('edit-product', compact('products'));
    }

    public function update(UpdateProductRequest $request, int $id)
    {
        $validated = $request->validated();
        $this->productService->updateProductInfo($id, $validated);
        return redirect()->route('products.show')
            ->with('success', 'Product updated successfully');
    }
}
