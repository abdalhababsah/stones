<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_seo')->insert([
            [
                'product_id' => 1,
                'meta_title' => 'Buy Smartphone Online',
                'meta_description' => 'Purchase the latest smartphone online at our store.',
                'seourl' => 'buy-smartphone-online',
            ],
        ]);
    }
}
