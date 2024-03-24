<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('homes')->insert([
            [
                'image_title_en' => 'Home Page', // English title
                'image_title_ar' => 'الصفحة الرئيسية', // Arabic title
                'image_path' => 'image.jpg',
                'sort_order' => 1,
            ],
        ]);
    }
}
