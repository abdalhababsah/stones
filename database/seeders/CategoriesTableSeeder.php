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
            ['name_en' => 'Electronics', 'slug' => 'electronics', 'description' => 'Electronic devices and gadgets.'],
            ['name_en' => 'Books', 'slug' => 'books', 'description' => 'All kinds of books.'],

        ]);
    }
}
