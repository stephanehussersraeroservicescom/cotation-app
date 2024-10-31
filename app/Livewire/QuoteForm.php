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
    public $user;
    public $userole;

    public $quoteId;
    public $removedQuoteLines = [];
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
            $this->quoteId = $this->quote->id;
            $this->user = \Auth::id();
            $this->userole = \Auth::user()->role;
            $this->SAE= $this->quote->SAE;
            $this->customer_name= $this->quote->customer_name;
            $this->customer_email= $this->quote->customer_email;
            $this->comments= $this->quote->comments;
            
            // Transform all quoteLines prices from cents to dollars
            foreach ($this->quoteLines as &$line) {
            $line['price'] = $line['price'] / 100;
            }

            // Authorize the user

            if ($this->user !== $this->quote->user_id && $this->userole!=='supervisor') {
                abort(403, 'Unauthorized action.');
            }

        } else {
            $this->user = \Auth::id();
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

        //dd($this->user);
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
        if (isset($this->quoteLines[$index]['id'])) {
            $this->removedQuoteLines[] = $this->quoteLines[$index]['id'];
        }
        unset($this->quoteLines[$index]);
        $this->quoteLines = array_values($this->quoteLines); // Reindex the array
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
        //dd($this->quoteLines);  

        \DB::transaction(function () {
            // Check if the quote exists
            if ($this->quoteId) {
                // Update the existing quote
                $quote = Quote::findOrFail($this->quoteId);





                $quote->update([
                    'user_id' => $this->user,
                    'customer_name' => $this->customer_name,
                    'customer_email' => $this->customer_email,
                    'date_entry' => $this->date_entry,
                    'date_valid' => $this->date_valid,
                    'comments' => $this->comments,
                ]);
    
                // Delete removed quote lines
                if (!empty($this->removedQuoteLines)) {
                    QuoteLine::whereIn('id', $this->removedQuoteLines)->delete();
                }
    
                // Update existing quote lines and create new ones
                foreach ($this->quoteLines as $line) {
                    if (isset($line['id'])) {
                        // Update existing quote line
                        $quoteLine = QuoteLine::findOrFail($line['id']);
                        $quoteLine->update([
                            'product_id' => $line['product_id'],
                            'part_number' => $line['part_number'],
                            'UOM' => $line['UOM'],
                            'price' => $line['price'],
                            'MOQ' => $line['MOQ'],
                        ]);
                    } else {
                        // Create new quote line
                        $quote->quoteLines()->create($line);
                    }
                }
            } else {
                // Create a new quote
                $quote = Quote::create([
                    'user_id' => $this->user,
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
