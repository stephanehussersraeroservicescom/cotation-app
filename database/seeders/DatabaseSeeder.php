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
            'description_LY' => 'Passes: Heat Release and Smoke Density: FAR25.853, Appendix F, Part IV and Part V, as well as 12 and 60 Second Vertical Flammability: FAR25.853, Appendix F, Part I (ii) and (i).<br>
                                    Roll Width: 54"<br>
                                    Average Roll Length: 33 LY<br>
                                    MOQ: 500 LY +/- 10%',

            'description_LM' => 'Passes: Heat Release and Smoke Density: FAR25.853, Appendix F, Part IV and Part V, as well as 12 and 60 Second Vertical Flammability: FAR25.853, Appendix F, Part I (ii) and (i).<br>
                                    Roll Width: 54"<br>
                                    Average Roll Length: 30 LM<br>
                                    MOQ: 450 LM +/- 10%',
        ]);

        Product::create([
            'product' => 'UL 900 with IR',
            'description_LY' => 'Passes: Heat Release and Smoke Density: FAR25.853, Appendix F, Part IV and Part V, as well as 12 and 60 Second Vertical Flammability: FAR25.853, Appendix F, Part I (ii) and (i).<br>
                                    Roll Width: 54"<br>
                                    Average Roll Length: 33 LY<br>
                                    MOQ: 500 LY +/- 10%',

            'description_LM' => 'Passes: Heat Release and Smoke Density: FAR25.853, Appendix F, Part IV and Part V, as well as 12 and 60 Second Vertical Flammability: FAR25.853, Appendix F, Part I (ii) and (i).<br>
                                    Roll Width: 54"<br>
                                    Average Roll Length: 30 LM<br>
                                    MOQ: 450 LM +/- 10%',
        ]);

        Product::create([
            'product' => 'BHCSS',
            'description_LY' => 'Passes: Heat Release and Smoke Density: FAR25.853, Appendix F, Part IV and Part V, as well as 12  and 60 Second Vertical Flammability: FAR25.853, Appendix F, Part I (ii) and (i).<br>
                                    Average Roll Length: 33 linear yards.<br>
                                    Material width : 54”.<br>
                                    MOQ custom product : 200 LY.<br>
                                    Lead time : 14 to 16 weeks.<br>',
            'description_LM' => 'Passes: Heat Release and Smoke Density: FAR25.853, Appendix F, Part IV and Part V, as well as 12  and 60 Second Vertical Flammability: FAR25.853, Appendix F, Part I (ii) and (i).<br>
                                    Average Roll Length: 30 LM.<br>
                                    Material width : 54”.<br>
                                    MOQ custom product : 181 LM.<br>
                                    Lead time : 14 to 16 weeks.<br>',
        ]);



        $products = Product::all();
        // Create 10 quotes
        Quote::factory(30)->create()->each(function ($quote) use ($products) {
            // For each quote, create a random number (1 to 5) of quote lines
            $quoteLineCount = rand(1, 3);

            QuoteLine::factory($quoteLineCount)->create([
                'quote_id' => $quote->id,
                // Randomly assign an existing product to each quote line
                'product_id' => $products->random()->id,
            ]);
        });



    }
}
