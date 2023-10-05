<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChillersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chillers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_id');
            $table->string('name');
            $table->string('merk');
            $table->string('type');
            $table->enum('category', ['BESAR', 'KECIL']);
            $table->integer('capacity');
            $table->string('photo')->nullable();
            $table->boolean('is_exclusive');
            $table->date('last_maintenance_date')->nullable();
            $table->date('placement_date')->nullable();
            $table->timestamps();


            $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chillers');
    }
}
