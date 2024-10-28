<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Quote;
use App\Models\Product;
use App\Models\QuoteLine;
use Illuminate\Support\Carbon;

class QuoteForm extends Component
{
    public $id;
    public $SAE;
    public $customer_name;
    public $customer_email;
    public $date_entry;
    public $date_valid;
    public $comments;
    public $textuel;

    public $quote;
    public $quoteLines = [];
    public $products = [];
    public $isEdit = false;


    public function mount($id = null)
    {  
        if ($id) {
            $this->quote = Quote::with('quoteLines.product')->findOrFail($id);
            $this->quoteLines = $this->quote->quoteLines->toArray();
            $this->isEdit = true;


            $this->SAE= $this->quote->SAE;
            $this->customer_name= $this->quote->customer_name;
            $this->customer_email= $this->quote->customer_email;
            $this->comments= $this->quote->comments;
            
            $this->textuel = 'Description: UltraLeather 900 & *UltraLeather 900 with ink resist.<br>
                                    Passes: Heat Release and Smoke Density: FAR25.853, Appendix F, Part IV and Part V, as well as 12 and 60 Second Vertical Flammability: FAR25.853, Appendix F, Part I (ii) and (i).<br>
                                    Roll Width: 54"<br>
                                    Average Roll Length: 33 LY<br>
                                    Shipping Terms: ExWorks Dallas Texas<br>
                                    MOQ: 500 LY +/- 10%';

            //dd($this->quote->customer_name);

            //dd($SAE);

            // Transform all quoteLines prices from cents to dollars
            foreach ($this->quoteLines as &$line) {
            $line['price'] = $line['price'] / 100;
            }

        } else {
            $this->quote = new Quote();
            $this->quoteLines = [];
            $this->isEdit = false;
            $this->quoteLines[] = [
                'product_id' => 1,
                'part_number' => '',
                'UOM' => 'LY',
                'price' =>'',
                'MOQ' =>'',
            ];
            
        }
        // Load all products for the dropdown
        $this->products = Product::all()->toArray();
        
        // Set default values for date_entry (today) and date_valid (1 month from today)
        $this->date_entry = Carbon::today()->toDateString();
        $this->date_valid = Carbon::today()->addMonth()->toDateString();

        //dd($this->quote->quoteLines[0]->part_number);
    }

    public function addQuoteLine()
    {
        // Add a new empty product line
        $this->quoteLines[] =  [
            'product_id' => 1,
            'part_number' => '',
            'UOM' => 'LY',
            'price' =>'',
            'MOQ' =>'',
        ];
    }

    public function removeQuoteLine($index)
    {
        // Remove the product line at the given index
        unset($this->quoteLines[$index]);
        $this->quoteLines = array_values($this->quoteLines); // Re-index the array
    }

    public function save()
    {

      
        // Validate the quote and product lines
        $this->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'date_entry' => 'required|date',
            'date_valid' => 'required|date|after_or_equal:date_entry',
            'quoteLines' => 'required|array|min:1',
            'quoteLines.*.product_id' => 'required|exists:products,id',
            'quoteLines.*.part_number' => 'required|string|max:255',
            'quoteLines.*.UOM' => 'required|in:LY,LM',
            'quoteLines.*.price' => 'required|numeric|min:0',
            'quoteLines.*.MOQ' => 'required|integer|min:1',
        ]);

       
        // Transform all quoteLines prices from dollars to cents
                foreach ($this->quoteLines as &$line) {
                    $line['price'] = $line['price'] * 100;
                }
        dd($this->quoteLines);  

        \DB::transaction(function () {
            // Create the quote
            $quote = Quote::create([
                'SAE' => $this->SAE,
                'customer_name' => $this->customer_name,
                'customer_email' => $this->customer_email,
                'date_entry' => $this->date_entry,
                'date_valid' => $this->date_valid,
                'comments' => $this->comments,
            ]);

            // Save each product line associated with the quote
            foreach ($this->quoteLines as $line) {
                $quote->quoteLines()->create($line);
            }
        });

        session()->flash('message', 'Quote and product lines saved successfully.');

        return redirect()->route('quotes.index');
    }


    protected function messages()
    {
        return [
            'quote.customer_name.required' => 'The customer name is required.',
            'quote.customer_email.required' => 'The customer email is required.',
            'quote.customer_email.email' => 'The customer email must be a valid email address.',
            'date_entry.required' => 'The entry date is required.',
            'date_valid.required' => 'The valid date is required.',
            'date_valid.after_or_equal' => 'The valid date must be after or equal to the entry date.',
            'quoteLines.required' => 'At least one quote line is required.',
            'quoteLines.*.product_id.required' => 'The product is required.',
            'quoteLines.*.product_id.exists' => 'The selected product does not exist.',
            'quoteLines.*.part_number.required' => 'The part number is required.',
            'quoteLines.*.UOM.required' => 'The unit of measure is required.',
            'quoteLines.*.UOM.in' => 'The unit of measure must be either LY or LM.',
            'quoteLines.*.price.required' => 'The price is required.',
            'quoteLines.*.price.numeric' => 'The price must be a number.',
            'quoteLines.*.price.min' => 'The price must be at least 0.',
            'quoteLines.*.MOQ.required' => 'The MOQ is required.',
            'quoteLines.*.MOQ.integer' => 'The MOQ must be an integer.',
            'quoteLines.*.MOQ.min' => 'The MOQ must be at least 1.',
        ];
    }

    public function render()
    {
        
        // return view('livewire.quote-form')->layout('components.layout', ['heading' => 'Create Quote']);
        return view('livewire.quote-form')->layout('layouts.app', ['heading' => 'Create Quote']);
    }
}
