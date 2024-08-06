<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSizeTable extends Migration
{
    public function up()
    {
        Schema::create('product_size_color', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('size_id');
            $table->unsignedBigInteger('color_id');
            $table->bigInteger('qty')->nullable();

            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('cascade');
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade');

            $table->primary(['product_id', 'size_id','color_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_size');
    }
}
