<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToMedicalReportsTable extends Migration
{
    public function up()
    {
        Schema::table('medical_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->foreign('appointment_id', 'appointment_fk_10158696')->references('id')->on('appointments');
        });
    }
}
