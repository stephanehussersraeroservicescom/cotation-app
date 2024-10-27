<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Mail\QuoteMail;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class QuoteController extends Controller
{
    public function preview($id)
    {
        $quote = Quote::with('quoteLines.product')->findOrFail($id);
        $SAE = $quote->SAE;
        $customer_name = $quote->customer_name;
        $date_entry = $quote->date_entry;
        $pdf = PDF::loadView('quotes.pdf', compact('quote'))->setPaper('a4')->output();

        $fileName = 'quote  ' . $SAE .' '.$id.' - '.$customer_name.' -- '.$date_entry.'.pdf';

        return view('quotes.preview', compact('quote', 'pdf', 'fileName'));
    }

    public function send(Request $request, $id)
    {
        $quote = Quote::with('quoteLines.product')->findOrFail($id);
        $SAE = $quote->SAE;
        $customer_name = $quote->customer_name;
        $date_entry = $quote->date_entry;
        $pdf = PDF::loadView('quotes.pdf', compact('quote'))->setPaper('a4')->output();

        $fileName = 'quote  ' . $SAE .' '.$id.' - '.$customer_name.' -- '.$date_entry.'.pdf';

        $fromAddress = Auth::user()->email; // Get the authenticated user's email address

        Mail::to($quote->customer_email)->send(new QuoteMail($quote, $pdf, $fileName, $fromAddress));

        return redirect()->route('quotes.index')->with('success', 'Quote sent successfully!');
    }
}

