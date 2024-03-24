<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductDimensionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('product_dimensions')->insert([
            [
                'product_id' => 1, // Assuming you have a product with ID 1
                'length' => 15.00,
                'width' => 7.00,
                'height' => 0.8,
                'dimension_unit' => 'cm',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more entries as needed
        ]);
    }
}
