<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdvertisementRubric extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisement_rubric', function (Blueprint $table) {
        $table->foreignId('advertisement_id')->unsigned();
        $table->foreign('advertisement_id')->references('id')->on('advertisements')->onDelete('cascade')->onUpdate('cascade');
        $table->foreignId('rubric_id')->unsigned();
        $table->foreign('rubric_id')->references('id')->on('rubrics')->onDelete('cascade')->onUpdate('cascade');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisement_rubric');
    }
}

