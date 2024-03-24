<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name_en' => 'Electronics',
                'name_ar' => 'إلكترونيات', // Arabic name
                'slug' => 'electronics',
                'description_en' => 'Electronic devices and gadgets.',
                'description_ar' => 'الأجهزة والأدوات الإلكترونية.' // Arabic description
            ],
            [
                'name_en' => 'Books',
                'name_ar' => 'كتب', // Arabic name
                'slug' => 'books',
                'description_en' => 'All kinds of books.',
                'description_ar' => 'جميع أنواع الكتب.' // Arabic description
            ],
        ]);
    }
}
