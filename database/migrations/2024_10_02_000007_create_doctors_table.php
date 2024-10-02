<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('specialty')->nullable();
            $table->string('crm')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
