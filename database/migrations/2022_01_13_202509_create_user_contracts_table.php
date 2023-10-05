<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->unsignedBigInteger('contract_type_id');
            $table->date('effective_date_start');
            $table->date('effective_date_end');
            $table->string('note')->nullable();
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('contract_type_id')->references('id')->on('contract_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_contracts');
    }
}
