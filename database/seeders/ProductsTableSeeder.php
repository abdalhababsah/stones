<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name_en' => 'Smartphone',
                'slug' => 'smartphone',
                'description' => 'A high-quality smartphone.',
                'qrcode' => null, // or generate a QR code value
                'category_id' => 1, // assuming Electronics is id 1
                'status' => 'active',
            ],
        ]);
    }
}
