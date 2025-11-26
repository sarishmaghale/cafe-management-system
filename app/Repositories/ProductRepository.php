<?php

namespace  App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{

    public function addNewProduct(array $product): Product
    {
        return Product::create($product);
    }
    public function updateProduct(Product $product, array $data): bool
    {
        return $product->update($data);
    }
    public function deleteProduct(Product $product): bool
    {
        $product->isDeleted = true;
        return $product->save();
    }

    public function getProductById(int $productId): Product
    {
        return Product::findOrFail($productId);
    }
    public function getAllProducts(): Collection
    {
        return Product::where('isDeleted', false)->get();
    }
    public function getTopProducts(): Collection
    {
        $topProducts = Product::withSum('orders', 'quantity') // calculates total quantity sold
            ->orderByDesc('orders_sum_quantity') // orders_sum_quantity is auto-created by withSum
            ->take(3)
            ->get();
        return $topProducts;
    }
}
