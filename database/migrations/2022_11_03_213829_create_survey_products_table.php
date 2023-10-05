<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('survey_detail_id');
            $table->unsignedBigInteger('product_chiller_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('sell_price', 10, 0, true);
            $table->unsignedInteger('stock');
            $table->unsignedInteger('sos');
            $table->unsignedFloat('percentage');
            $table->boolean('status');
            $table->timestamps();

            $table->unique(['survey_detail_id', 'product_chiller_id']);
            $table->foreign('survey_detail_id')->references('id')->on('survey_details');
            $table->foreign('product_chiller_id')->references('id')->on('product_chillers');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_products');
    }
}
