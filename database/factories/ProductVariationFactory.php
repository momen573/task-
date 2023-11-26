<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductVariation;
use App\Models\Product;

class ProductVariationFactory extends Factory
{
    protected $model = ProductVariation::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'color' => $this->faker->colorName,
            'price' => $this->faker->randomFloat(2, 10, 100),
        ];
    }
}
