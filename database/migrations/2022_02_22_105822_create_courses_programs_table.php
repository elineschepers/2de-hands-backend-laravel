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
        Schema::create('courses_programs', function (Blueprint $table) {
            $table->bigInteger('course_id')->unsigned();
            $table->bigInteger('program_id')->unsigned();
            $table->unique(['course_id', 'program_id']);
            $table->text('extra')->nullable();

            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('program_id')->references('id')->on('programs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses_programs');
    }
};
