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
            $table->string('title');
            $table->string('slug');
            $table->text('short_description');
            $table->text('detail_description');
            $table->string('shipping_returns');
            $table->string('new_price');
            $table->string('old_price');
            $table->string('stock');
            $table->integer('category');
            $table->integer('subcategory');
            $table->integer('brand');
            $table->string('sku');
            $table->string('barcode');
            $table->string('color');
            $table->string('size');
            $table->string('quantity');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
