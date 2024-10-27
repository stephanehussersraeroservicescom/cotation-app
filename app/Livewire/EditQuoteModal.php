<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Quote;
use App\Models\QuoteLine;
use App\Models\Product;

class EditQuoteModal extends Component
{
    public $quote;
    public $quoteLines = [];
    public $products = [];
    public $showModal = false;

    protected $listeners = ['editQuote'];

    public function editQuote($quoteId)
    {
        $this->quote = Quote::with('quoteLines.product')->findOrFail($quoteId);
        $this->quoteLines = $this->quoteSelected->quoteLines->toArray();
        $this->products = Product::all()->toArray();
        $this->showModal = true;
    }

    public function save()
    {
        $this->quote->save();
        foreach ($this->quoteLines as $line) {
            QuoteLine::find($line['id'])->update($line);
        }
        $this->showModal = false;
        $this->emit('quoteUpdated');
    }

    public function render()
    {
        return view('livewire.edit-quote-modal');
    }
}