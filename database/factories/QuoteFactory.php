<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

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
            'customer_name' => fake()->name(),
            'customer_email' => fake()->safeEmail(),
            'date_entry' => now(),
            'date_valid' => now(),
            'shipping_terms' => 'ExWorks Dallas Texas',
            'payment_terms' => fake()->randomElement(['ProForma', '30 days', '60 days']),
            'comments' => fake()->text(),
            'user_id' => User::all()->random()->id,
        ];
    }
 

}
