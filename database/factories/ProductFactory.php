<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->name;
        return [
            'is_active'         => 1,
            'is_deleted'        => 0,
            'name'              => $name,
            'slug'              => Str::slug($name),
            'category_id'       => Category::inRandomOrder()->first()->id,
            'brand_id'          => Brand::inRandomOrder()->first()->id,
            'unit_id'           => Unit::inRandomOrder()->first()->id,
            'sku'               => generateUniqueSkuCode($name),
            'short_description' => $this->faker->sentence(60, true),
            'description'       => $this->faker->sentence(160, true),
            'created_at'        => now(),
        ];
    }
}
