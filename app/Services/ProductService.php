<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductService
{
    public function __construct(protected ProductRepository $productRepo) {}

    public function fetchAllProducts()
    {
        return $this->productRepo->getAllProducts();
    }

    public function addNewProduct($productData)
    {
        return $this->productRepo->addNewProduct($productData);
    }

    public function updateProductInfo($id, $data)
    {
        $product = $this->productRepo->getProductById($id);
        if (!$product) {
            return null;
        }
        $this->productRepo->updateProduct($product, $data);
        return  $product->fresh();
    }
    public function fetchProductById(int $id)
    {
        $product = $this->productRepo->getProductById($id);
        if (!$product) {
            throw new ModelNotFoundException("Product not found");
        }
        return $product;
    }
    public function activateSoftDelete(int $id)
    {
        $product = $this->productRepo->getProductById($id);
        if ($product) {
            return $this->productRepo->deleteProduct($product);
        }
    }
}
