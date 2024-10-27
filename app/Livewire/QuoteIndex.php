<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Quote;
use App\Models\QuoteLine;
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
    public $searchDateEntry;
    public $searchStatus;
    Public $header='test';

    public function print($id)
    {
        $quote = Quote::with('quoteLines.product')->findOrFail($id);
        $SAE = $quote->SAE;
        $customer_name = $quote->customer_name;
        $date_entry = $quote->date_entry;
        $pdf = PDF::loadView('quotes.pdf', compact('quote'))->setPaper('a4');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'quote  ' . $SAE .' '.$id.' - '.$customer_name.' -- '.$date_entry.'.pdf');
    }

    public function previewEmail($id)
    {
        return redirect()->route('quote.preview', $id);
    }

    public function emailQuote($id)
    {
        $quote = Quote::with('quoteLines.product')->findOrFail($id);
        $SAE = $quote->SAE;
        $customer_name = $quote->customer_name;
        $date_entry = $quote->date_entry;
        $pdf = PDF::loadView('quotes.pdf', compact('quote'))->setPaper('a4')->output();

        $fileName = 'quote  ' . $SAE .' '.$id.' - '.$customer_name.' -- '.$date_entry.'.pdf';
        $fromAddress = auth()->user()->email; 
        Mail::to($quote->customer_email)->send(new QuoteMail($quote, $pdf, $fileName, $fromAddress));
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

            if ($this->searchDateEntry) {
                $quotes->whereDate('date_entry', $this->searchDateEntry);
            }

            if ($this->searchStatus) {
                $quotes->where('comments', 'like', '%'.$this->searchStatus.'%');
            }

            return view('livewire.quote-index', [
                'quotes' => $quotes->get(),
            ]);
        }

}
