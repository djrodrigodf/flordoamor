<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsurancesTable extends Migration
{
    public function up()
    {
        Schema::create('insurances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('insurance_name')->nullable();
            $table->string('policy_number')->nullable();
            $table->date('valid_until')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
