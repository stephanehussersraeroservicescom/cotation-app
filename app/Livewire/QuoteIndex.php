<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Quote;
use App\Models\QuoteLine;
use App\Models\Product;
use App\Livewire\QuoteForm;
use PDF;
use Mail;
use App\Mail\QuoteMail;
use routes\web;
use Illuminate\Support\Carbon;

class QuoteIndex extends Component
{
    public $searchId;
    public $searchInitials;
    public $searchCustomerName;
    public $searchComments;
    public $userole;   
    public $quotes;
    public $user;

  
    // public function mount()
    // {
    //     $this->userole = \Auth::user()->role;
        
    //     if ( $this->userole!=='supervisor') {
    //         $this->quotes=Quote::where('user_id', \Auth::id())->get();
    //     } else {    
    //         $this->quotes=Quote::all();
    //     }

    // }


    //************************************************************************** */
    public function editQuote($id)
    {
        return redirect()->route('quote.edit', $id);
    }




    /************************************************************************
    *PRINT PDF quote**/


    public function print($id)
    {
        $quote = Quote::with(['quoteLines.product', 'user'])->findOrFail($id);
  
        // Authorize the user
        $this->userole = \Auth::user()->role;
        $this->user = \Auth::id();
        if ($this->user !== $quote->user_id && $this->userole !== 'supervisor') {
            abort(403, 'Unauthorized action.');
        }

        //dd($quote->user->initials);
        $initials = $quote->user->initials;
        $customer_name = $quote->customer_name;
        $date_entry = $quote->date_entry;
        $imagepath = public_path('storage/images/tapis-logo-small.png');
        
        $pdf = PDF::loadView('quotes.pdf', compact('quote', 'imagepath'))->setPaper('a4');
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'quote  ' . $initials .' '.$id.' - '.$customer_name.' -- '.$date_entry.'.pdf');
    }


    /************************************************************************#
    **Preview before sending */

    public function previewEmail($id)
    {
        
        return redirect()->route('quote.preview', $id);
       
    }

    
    /************************************************************************#
    **Render */

    public function render()
    {
        // Initialize the query
        $this->userole = \Auth::user()->role;
        $this->user = \Auth::id();
    
        if ($this->userole == 'supervisor') {
            $this->quotes = Quote::query();
        } else {
            $this->quotes = Quote::where('user_id', $this->user);
        }
        //dd($this->quotes);   
        // Apply filters
        if ($this->searchId) {
            $this->quotes->where('id', 'like', '%'.$this->searchId.'%');
        }
    
        if ($this->searchInitials) {
            $this->quotes->whereHas('user', function ($query) {
                $query->where('initials', 'like', '%'.$this->searchInitials.'%');
            });
        }
    
        if ($this->searchCustomerName) {
            $this->quotes->where('customer_name', 'like', '%'.$this->searchCustomerName.'%');
        }
    
        if ($this->searchComments) {
            $this->quotes->where('comments', 'like', '%'.$this->searchComments.'%');
        }
    
        // Execute the query and get the results
        $this->quotes = $this->quotes->get();
    
        // Ensure $quotes is always an array or collection
        if ($this->quotes === null) {
            $this->quotes = collect();
        }
    
        // Return the view with the filtered quotes
        return view('livewire.quote-index', [
            'quotes' => $this->quotes,
        ])->layout('layouts.app', ['heading' => 'Quotes']);
    }

    // public function render()
    //     {
    //         $quotes = $this->quotes->toQuery();

    //         if ($this->searchId) {
    //             $quotes->where('id', 'like', '%'.$this->searchId.'%');
    //         }

    //         if ($this->searchInitials) {
    //             $quotes->whereHas('user', function ($query) {
    //                 $query->where('initials','like', '%'.$this->searchInitials.'%');
    //             });
    //         }

    //         if ($this->searchCustomerName) {
    //             $quotes->where('customer_name', 'like', '%'.$this->searchCustomerName.'%');
    //         }


    //         if ($this->searchComments) {
    //             $quotes->where('comments', 'like', '%'.$this->searchComments.'%');
    //         }

    //         return view('livewire.quote-index', [
    //             'quotes' => $quotes->get(),
    //         ])->layout('layouts.app', ['heading' => 'Quotes']);
    //     }

}
