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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('invoice_id'); // Relacionamento com a fatura
            $table->unsignedBigInteger('product_id'); // Relacionamento com o produto
            $table->integer('quantity'); // Quantidade do produto
            $table->decimal('price', 10, 2); // Preço unitário do produto
            $table->timestamps();

            // Foreign key para a fatura
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            // Foreign key para o produto
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
