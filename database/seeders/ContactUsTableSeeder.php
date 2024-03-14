<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactUsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contact_us')->insert([
            [
                'name' => 'Company Name',
                'email' => 'contact@company.com',
                'number' => '123-456-7890',
                'description' => 'Contact us any time.',
            ],
        ]);
    }
}
