<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('client_area_hour_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->char('type', 1); // Attendance::types
            $table->tinyInteger('status'); // Attendance::status
            $table->string('shift')->default('non')->comment('non / s1 / s2 / s3');
            $table->string('in_latitude');
            $table->string('in_longitude');
            $table->string('in_photo')->nullable();
            $table->string('in_attachment')->nullable();
            $table->dateTime('in_log_start');
            $table->dateTime('in_log_end');
            $table->string('out_latitude')->nullable();
            $table->string('out_longitude')->nullable();
            $table->string('out_photo')->nullable();
            $table->string('out_attachment')->nullable();
            $table->dateTime('out_log_start')->nullable();
            $table->dateTime('out_log_end')->nullable();
            $table->string('note')->nullable();
            $table->string('working_from')->nullable();
            $table->boolean('is_late')->nullable();
            $table->boolean('is_halfday')->nullable();
            $table->string('approved_note')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('client_area_hour_id')->references('id')->on('client_area_hours')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('approved_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
