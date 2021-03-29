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
            $table->string('name');
            $table->foreignId('category_id');
            $table->foreignId('user_id');
            $table->foreignId('unit_id');
            $table->foreignId('currency_id');
            $table->foreignId('brand_id');
            $table->integer('stock');
            $table->string('default_image');
            $table->string('meta_keywords');
            $table->string('meta_description');
            $table->string('short_description');
            $table->string('long_description'); // You may want to create a new table for this
            $table->string('slug');
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
        Schema::dropIfExists('products');
    }
}
