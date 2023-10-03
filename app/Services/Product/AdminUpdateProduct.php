<?php

namespace App\Services\Product;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class AdminUpdateProduct
{
    /**
     * @var array
     */
    private array $productNewParams = [];

    /**
     * @var array
     */
    private array $productNewVariations = [];

    private ?Product $product;

    /**
     * @param array $request
     * @param Product $product
     * @return Product
     */
    public function do(array $request, Product $product,): Product
    {
        $this->productNewParams = [
            'title' => $request['title'],
            'price' => $request['price']
        ];

        $this->product = $product;

        $this->productNewVariations = $request['variations'];

        DB::transaction(function () {
            $this->product->update($this->productNewParams);
            $this->product->variations()->sync(array_column($this->productNewVariations, 'id'));
        });

        return $this->product;
    }
}
