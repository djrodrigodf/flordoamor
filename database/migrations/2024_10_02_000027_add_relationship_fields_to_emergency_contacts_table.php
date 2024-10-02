<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEmergencyContactsTable extends Migration
{
    public function up()
    {
        Schema::table('emergency_contacts', function (Blueprint $table) {
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->foreign('patient_id', 'patient_fk_10158721')->references('id')->on('patients');
        });
    }
}
