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
    public $searchSae;
    public $searchCustomerName;
    public $searchComments;

  



    //************************************************************************** */
    public function editQuote($id)
    {
        return redirect()->route('quote.form', $id);
    }




    /************************************************************************
    *PRINT PDF quote**/


    public function print($id)
    {
        $quote = Quote::with('quoteLines.product')->findOrFail($id);
        $SAE = $quote->SAE;
        $customer_name = $quote->customer_name;
        $date_entry = $quote->date_entry;
        $imagepath = public_path('storage/images/tapis-logo.png');
        
        $pdf = PDF::loadView('quotes.pdf', compact('quote', 'imagepath'))->setPaper('a4');
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'quote  ' . $SAE .' '.$id.' - '.$customer_name.' -- '.$date_entry.'.pdf');
    }


    /************************************************************************#
    **Preview before sending */

    public function previewEmail($id)
    {
        return redirect()->route('quote.preview', $id);
    }

    


    public function render()
        {
            $quotes = Quote::query();

            if ($this->searchId) {
                $quotes->where('id', 'like', '%'.$this->searchId.'%');
            }

            if ($this->searchSae) {
                $quotes->where('sae', 'like', '%'.$this->searchSae.'%');
            }

            if ($this->searchCustomerName) {
                $quotes->where('customer_name', 'like', '%'.$this->searchCustomerName.'%');
            }


            if ($this->searchComments) {
                $quotes->where('comments', 'like', '%'.$this->searchComments.'%');
            }

            return view('livewire.quote-index', [
                'quotes' => $quotes->get(),
            ])->layout('layouts.app', ['heading' => 'Quotes']);
        }

}
