<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'SAE'=>fake()->randomElement(['SH', 'JE', 'DD', 'NT']),
            'customer_name'=>fake()->name(),
            'customer_email'=>fake()->safeEmail(),
            'date_entry'=>now(),
            'date_valid'=>now(),
            'comments'=>fake()->text(),
        ];
    }
 

}
