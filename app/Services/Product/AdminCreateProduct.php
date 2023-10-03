<?php

namespace App\Services\Product;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class AdminCreateProduct
{
    /**
     * @var array
     */
    private array $newProductParams = [];

    /**
     * @var array
     */
    private array $newProductVariations = [];

    const ATTEMPT = 3;

    /**
     * @param array $request
     * @return Product
     */
    public function do(array $request): Product
    {
        $this->newProductParams = [
            'title' => $request['title'],
            'price' => $request['price']
        ];

        $this->newProductVariations = $request['variations'];

        return DB::transaction(function () {
            $product = Product::create($this->newProductParams);
            $this->assignVariationToNewProduct($product);
            return $product;
        }, self::ATTEMPT);
    }

    /**
     * @param Product $product
     * @return void
     */
    private function assignVariationToNewProduct(Product $product): void
    {
        foreach ($this->newProductVariations as $variation) {
            $product->variations()->attach($product->id, [
                'variation_id' => $variation['id']
            ]);
        }
    }
}
