<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteLine extends Model
{
    /** @use HasFactory<\Database\Factories\QuoteLineFactory> */
    use HasFactory;

    protected $guarded = [];
    
    public function quote_id(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
