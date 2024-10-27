<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Quote;
use App\Models\Product;
use App\Models\QuoteLine;
use Illuminate\Support\Carbon;

class QuoteForm extends Component
{
    public $SAE;
    public $customer_name;
    public $customer_email;
    public $date_entry;
    public $date_valid;
    public $comments;
    

    public $quoteLines = [];
    public $products; // To store product options for dropdown

    public function mount()
    {
        // Load all products for the dropdown
        $this->products = Product::all();

        // Initialize the first product line with default values
        $this->quoteLines[] = ['product_id' => null, 'part_number' => '', 'UOM' => 'LY', 'price' => 0, 'MOQ' => 1];

        // Set default values for date_entry (today) and date_valid (1 month from today)
        $this->date_entry = Carbon::today()->toDateString();
        $this->date_valid = Carbon::today()->addMonth()->toDateString();
    }

    public function addQuoteLine()
    {
        // Add a new empty product line
        $this->quoteLines[] = ['product_id' => null, 'part_number' => '', 'UOM' => 'LY', 'price' => 0, 'MOQ' => 1];
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
            'customer_email' => 'nullable|email',
            'date_entry' => 'required|date',
            'date_valid' => 'required|date|after_or_equal:date_entry',
            'quoteLines' => 'required|array|min:1',
            'quoteLines.*.product_id' => 'required|exists:products,id',
            'quoteLines.*.part_number' => 'required|string|max:255',
            'quoteLines.*.UOM' => 'required|in:LY,LM,EACH',
            'quoteLines.*.price' => 'required|numeric|min:0',
            'quoteLines.*.MOQ' => 'required|integer|min:1',
        ]);

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

    public function render()
    {
        
        // return view('livewire.quote-form')->layout('components.layout', ['heading' => 'Create Quote']);
        return view('livewire.quote-form');
    }
}
