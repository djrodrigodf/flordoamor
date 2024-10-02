<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergencyContactsTable extends Migration
{
    public function up()
    {
        Schema::create('emergency_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('relationship')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
