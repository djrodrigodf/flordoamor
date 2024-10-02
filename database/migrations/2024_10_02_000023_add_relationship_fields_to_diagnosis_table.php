<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDiagnosisTable extends Migration
{
    public function up()
    {
        Schema::table('diagnosis', function (Blueprint $table) {
            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->foreign('appointment_id', 'appointment_fk_10158640')->references('id')->on('appointments');
        });
    }
}
