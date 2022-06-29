<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers_courses', function (Blueprint $table) {
            $table->bigInteger('offer_id')->unsigned();
            $table->bigInteger('course_id')->unsigned();
            $table->unique(['offer_id', 'course_id']);

            $table->foreign('offer_id')->references('id')->on('offers');
            $table->foreign('course_id')->references('id')->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers_courses');
    }
};
