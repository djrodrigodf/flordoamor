<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->foreign('patient_id', 'patient_fk_10158615')->references('id')->on('patients');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->foreign('doctor_id', 'doctor_fk_10158617')->references('id')->on('doctors');
        });
    }
}
