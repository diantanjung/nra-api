<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_areas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('area_id');
            $table->string('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('radius');
            $table->string('gmaps_url')->nullable();
            $table->string('site_photo')->nullable();
            $table->string('qr_photo')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('areas');
            $table->unique(['client_id', 'area_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_areas');
    }
}
