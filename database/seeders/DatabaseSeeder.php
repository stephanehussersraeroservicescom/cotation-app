<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Quote;
use App\Models\Product;
use App\Models\QuoteLine;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
     

        User::factory()->create([
            'name' => 'stef',
            'email' => 'stephane.paris75@jmail.cj',
            'password'=> bcrypt('password'),
        ]);

        Product::create([
            'product' => 'UL 900',
            'description_LY' => 'UL 900 description in LY',
            'description_LM' => 'UL 900 description in LM',
        ]);

        Product::create([
            'product' => 'UL 900 with IR',
            'description_LY' => 'UL 900 with IR description in LY',
            'description_LM' => 'UL 900 with IR description in LM',
        ]);

        Product::create([
            'product' => 'BHCSS',
            'description_LY' => 'BHCSS description in LY',
            'description_LM' => 'BHCSS description in LM',
        ]);



        $products = Product::all();
        // Create 10 quotes
        Quote::factory(110)->create()->each(function ($quote) use ($products) {
            // For each quote, create a random number (1 to 5) of quote lines
            $quoteLineCount = rand(1, 6);

            QuoteLine::factory($quoteLineCount)->create([
                'quote_id' => $quote->id,
                // Randomly assign an existing product to each quote line
                'product_id' => $products->random()->id,
            ]);
        });



    }
}
