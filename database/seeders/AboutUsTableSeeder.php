<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutUsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('about_us')->insert([
            [
                'image_path' => 'image.jpg',
                'content_en' => 'About us content goes here.',
                'content_ar' => 'هنا محتوى الصفحه',

            ],
        ]);
    }
}
