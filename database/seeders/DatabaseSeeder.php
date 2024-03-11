<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Address;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersSeeder::class,
            RolesPermissionsSeeder::class,
            BrandSeeder::class,
            CategoryGroupSeeder::class,
            CategorySeeder::class,
            AttributeGroupSeeder::class,
            AttributeSeeder::class,
            ProductStatusSeeder::class,
            TagSeeder::class,
            CategoryAttributegroupSeeder::class,
            // CategoryAttributegroupSeeder::class,
            ProductStatusSeeder::class,
            ProductSeeder::class,
            CustomersTableSeeder::class,
            OrderStatusSeeder::class,
            OrderSeeder::class,
            OrderProductSeeder::class,
        ]);

    }
}
