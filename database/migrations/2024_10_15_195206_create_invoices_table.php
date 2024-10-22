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
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_id'); // Relacionamento com o cliente (paciente)
            $table->decimal('total_amount', 10, 2); // Valor total dos produtos
            $table->string('payment_method')->nullable(); // Forma de pagamento
            $table->string('payment_status')->default('Aguardando Pagamento'); // Status do pagamento
            $table->timestamps();

            // Foreign key para o cliente (paciente)
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
