<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionVariationSeeder extends Seeder
{
    private static array $variables = [
        [
            'variation_id' => 1,
            'option_id'    => 1,
        ],
        [
            'variation_id' => 1,
            'option_id'    => 2,
        ],
        [
            'variation_id' => 1,
            'option_id'    => 3,
        ],
        [
            'variation_id' => 2,
            'option_id'    => 4,
        ],
        [
            'variation_id' => 2,
            'option_id'    => 5,
        ],
        [
            'variation_id' => 2,
            'option_id'    => 6,
        ],
        [
            'variation_id' => 3,
            'option_id'    => 7,
        ],
        [
            'variation_id' => 3,
            'option_id'    => 8,
        ],
        [
            'variation_id' => 3,
            'option_id'    => 9,
        ],
        [
            'variation_id' => 4,
            'option_id'    => 10,
        ],
        [
            'variation_id' => 4,
            'option_id'    => 11,
        ],
        [
            'variation_id' => 5,
            'option_id'    => 12,
        ],
        [
            'variation_id' => 5,
            'option_id'    => 13,
        ],

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
