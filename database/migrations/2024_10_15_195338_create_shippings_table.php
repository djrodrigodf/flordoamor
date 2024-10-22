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
        Schema::create('shippings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('invoice_id'); // Relacionamento com a fatura
            $table->decimal('shipping_cost', 10, 2); // Custo do envio
            $table->string('tracking_number')->nullable(); // Número de rastreamento
            $table->string('carrier')->nullable(); // Transportadora (Correios, UPS, etc.)
            $table->string('status')->default('pending'); // Status do envio (pendente, enviado, etc.)
            $table->timestamps();

            // Foreign key para a fatura
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
