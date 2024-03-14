<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition()
    {
        return [
            'name_en' => $this->faker->company,
            'icon_path' => $this->faker->imageUrl(100, 100, 'business'),
            'sort_order' => $this->faker->numberBetween(1, 100),
        ];
    }
}
