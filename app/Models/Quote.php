<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Quote;

class Quote extends Model
{
    /** @use HasFactory<\Database\Factories\QuoteFactory> */
    use HasFactory;


    protected $guarded = [];


    public function quoteLines()
    {
        return $this->HasMany(QuoteLine::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
