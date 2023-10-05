<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductChillersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_chillers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('chiller_id');
            $table->decimal('sell_price', 10, 0, true);
            $table->unsignedInteger('stock');
            $table->boolean('status')->default(true);
            $table->boolean('is_competitor')->default(false);
            $table->string('product_competitor')->nullable();
            $table->timestamps();

            $table->unique(['product_id', 'chiller_id']);
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('chiller_id')->references('id')->on('chillers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_chillers');
    }
}
