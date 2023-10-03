<?php

namespace Database\Seeders;

use App\Enums\OrderStatusEnums;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::create([
            'product_id' => 1,
            'user_id'    => 1,
            'status'     => OrderStatusEnums::WAITING->value,
            'detail'     => 'sample detail',
            'price'      => 40
        ]);
    }
}
