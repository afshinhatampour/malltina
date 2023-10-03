<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * @var array|array[]
     */
    private static array $optionAttributes = [
        ['title' => 'skim'],
        ['title' => 'semi'],
        ['title' => 'whole'],
        ['title' => 'small'],
        ['title' => 'medium'],
        ['title' => 'large'],
        ['title' => 'single'],
        ['title' => 'double'],
        ['title' => 'triple'],
        ['title' => 'chocolate chip'],
        ['title' => 'ginger'],
        ['title' => 'take away'],
        ['title' => 'in shop']
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$optionAttributes as $optionAttribute) {
            Option::create($optionAttribute);
        }
    }
}
