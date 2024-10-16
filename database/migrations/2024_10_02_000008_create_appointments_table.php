<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('appointment_date');
            $table->longText('reason')->nullable();
            $table->longText('diagnosis')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
