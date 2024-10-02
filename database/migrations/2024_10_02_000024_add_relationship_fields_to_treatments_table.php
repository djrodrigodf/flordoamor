<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTreatmentsTable extends Migration
{
    public function up()
    {
        Schema::table('treatments', function (Blueprint $table) {
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->foreign('patient_id', 'patient_fk_10158667')->references('id')->on('patients');
        });
    }
}
