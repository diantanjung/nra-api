<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('supplier_id');
            $table->string('sku')->unique();
            $table->string('barcode_id')->unique()->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('photo');
            $table->string('uom')->nullable();
            $table->integer('weight');
            $table->string('weight_type');
            $table->integer('recommendation');
            $table->integer('depth');
            $table->decimal('sell_price', 10, 0, true);
            $table->boolean('is_rtd')->default(false);
            $table->boolean('is_sales')->default(false);
            $table->timestamps();


            $table->foreign('category_id')->references('id')->on('product_categories');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
