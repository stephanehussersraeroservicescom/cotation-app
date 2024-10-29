<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Quote;

class TestRoute extends Component
{
    public $quotes;
    public function mount()
    {
        $this->quotes = Quote::with('user')->where('id', '3')->get();
        dd($this->quotes);
    }
    

    public function render()
    {
        return view('livewire.test-route');
    }
}
