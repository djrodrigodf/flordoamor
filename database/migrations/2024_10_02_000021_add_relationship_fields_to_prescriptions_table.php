<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPrescriptionsTable extends Migration
{
    public function up()
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->foreign('appointment_id', 'appointment_fk_10158624')->references('id')->on('appointments');
        });
    }
}
