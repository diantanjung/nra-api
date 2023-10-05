<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('photo');
            $table->string('contact_name');
            $table->string('contact_number')->nullable();
            $table->unsignedInteger('province_id')->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->string('address')->nullable();
            $table->string('full_address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->boolean('is_closed')->nullable();
            $table->dateTime('is_closed_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchants');
    }
}
