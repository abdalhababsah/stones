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
                'name_ar' => 'هاتف ذكي',
                'slug_en' => 'smartphone',
                'slug_ar' => 'هاتف-ذكي',

                'description_en' => 'A high-quality smartphone.',
                'description_ar' => 'هاتف ذكي عالي الجودة.',
                'qrcode' => null,
                'category_id' => 1,
                'status' => 'active',
            ],
        ]);
    }
}
