<?php

namespace Database\Factories;

use App\Models\QuoteLine;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuoteLine>
 */
class QuoteLineFactory extends Factory
{
    protected $model = QuoteLine::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::all()->random()->id, // Select an existing product
            'part_number' => 'ULFRB' . fake()->randomNumber(4, true), // Generate a part number
            'UOM' => fake()->randomElement(['LY', 'LM']), // Randomly select a unit of measure
            'price' => fake()->numberBetween(10000, 40000), // Generate a price between 1000 and 10000
            'MOQ' => fake()->numberBetween(200, 500), // Generate a minimum order quantity
        ];
    }
}
