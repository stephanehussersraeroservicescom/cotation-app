<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->date('date_entry');
            $table->date('date_valid');
            $table->string('shipping_terms')->default('Ex Works Dallas Texas')->nullable(false);
            $table->string('payment_terms')->default('Pro Forma');
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
