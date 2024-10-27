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
        Schema::create('quote_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable();
            $table->foreignId('quote_id')->nullable();
            $table->string('part_number');
            $table->set('UOM', ['LY', 'LM']);
            $table->integer('price');
            $table->integer('MOQ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_lines');
    }
};
