<?php

namespace Database\Seeders;

use App\Models\Variation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VariationSeeder extends Seeder
{
    /**
     * @var array|array[]
     */
    private static array $variationAttributes = [
        ['title' => 'Milk'],
        ['title' => 'Size'],
        ['title' => 'Shots'],
        ['title' => 'Kind'],
        ['title' => 'Consume location']
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$variationAttributes as $variationAttribute) {
            Variation::create($variationAttribute);
        }
    }
}
