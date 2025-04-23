<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sale;

class SaleSeeder extends Seeder
{
    public function run()
    {
        Sale::create([
            'user_id' => 1,
            'total_amount' => 4.85,
            'sale_date' => now(),
        ]);

        Sale::create([
            'user_id' => 2,
            'total_amount' => 2.20,
            'sale_date' => now(),
        ]);
    }
}

