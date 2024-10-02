<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalReportsTable extends Migration
{
    public function up()
    {
        Schema::create('medical_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('report_type')->nullable();
            $table->longText('observations')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
