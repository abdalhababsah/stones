<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('variants')->insert([
            [
                'product_id' => 1, // assuming the first product
                'variant_type_id' => 1, // assuming 'Color' is id 1
                'variant_value' => 'Black',
                'price' => 999.99,
            ],
        ]);
    }
}
