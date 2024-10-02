<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionsTable extends Migration
{
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('medication')->nullable();
            $table->longText('dosage')->nullable();
            $table->longText('duration')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
