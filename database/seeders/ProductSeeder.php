<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * @var array|string[]
     */
    private static array $productsAttributes = [
        ['title' => 'Latte', 'price' => 60],
        ['title' => 'Cappuccino', 'price' => 65],
        ['title' => 'Espresso', 'price' => 70],
        ['title' => 'Tea', 'price' => 30],
        ['title' => 'Hot chocolate', 'price' => 50],
        ['title' => 'Cookie', 'price' => 45],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$productsAttributes as $productsAttribute) {
            Product::create($productsAttribute);
        }
    }
}
