<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\QuoteForm;
use App\Livewire\ShowQuote;
use App\Livewire\QuoteIndex;
use App\Http\Controllers\QuoteController;
use App\Models\Quote;
use App\Models\QuoteLine;

// Route::get('/', function () {
//     return view('welcome');
// })->name('welcome');



Route::get('/', function () {
    return redirect()->route('login');
})->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});



    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        Route::get('/quotes', QuoteIndex::class)->name('quotes.index');
        Route::get('/quote-form', QuoteForm::class)->name('quotes.form');
        Route::get('/quote-form/{id?}', QuoteForm::class)->name('quote.edit');
        Route::get('/quote/{id}/preview', [QuoteController::class, 'preview'])->name('quote.preview');
        Route::post('/quote/{id}/send', [QuoteController::class, 'send'])->name('quote.send');
    });





// Pas sur d en avoir besoin //
Route::get('/quotes/{id}', ShowQuote::class)->name('quote.show');





