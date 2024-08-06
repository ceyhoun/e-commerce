<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->double('price')->default(0)->nullable();
            $table->bigInteger('qty')->default(1)->nullable();
            $table->text('description')->nullable();
            $table->string('images')->default('newlogo.jpeg')->nullable();
            $table->unsignedBigInteger('size_id')->nullable();
            $table->unsignedBigInteger('color_id')->nullable();
            $table->boolean('status')->default(false)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('images');

    }
};
