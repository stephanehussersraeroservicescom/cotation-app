<?php

namespace App\Livewire;

use App\Models\Quote; 
use Livewire\Component;

class ShowQuote extends Component
{
    public $id;

    public function mount($id)
    {
        $this->id = $id;
        $this->data = Quote::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.show-quote');
    }
}
