<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('event_id')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('total_item');
            $table->integer('total_amount');
            $table->integer('pay_amount');
            $table->integer('return_amount');
            $table->string('customer_name')->nullable();
            $table->string('customer_phone_number')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('event_id')->references('id')->on('events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
