<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDocumentsTable extends Migration
{
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->foreign('patient_id', 'patient_fk_10158632')->references('id')->on('patients');
        });
    }
}
