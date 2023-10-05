<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('schedule_id')->unique();
            $table->tinyInteger('status')->default(0);
            $table->dateTime('log_start');
            $table->dateTime('log_end')->nullable();
            $table->string('coordinat')->nullable();
            $table->string('checkin_photo')->nullable();
            $table->boolean('checked_chillers')->default(0);
            $table->boolean('checked_products')->default(0);
            $table->boolean('is_closed')->default(0);
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('schedule_id')->references('id')->on('survey_schedules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surveys');
    }
}
