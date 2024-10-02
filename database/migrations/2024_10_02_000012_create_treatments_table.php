<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreatmentsTable extends Migration
{
    public function up()
    {
        Schema::create('treatments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('treatment_plan')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
