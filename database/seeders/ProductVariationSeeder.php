<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductVariationSeeder extends Seeder
{
    private static array $variables = [
        [
            'product_id'   => 1,
            'variation_id' => 1
        ],
        [
            'product_id'   => 1,
            'variation_id' => 5
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$variables as $variable) {
            DB::table('option_variation')->insert($variable);
        }
    }
}
