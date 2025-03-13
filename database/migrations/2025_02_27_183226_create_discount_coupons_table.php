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
        Schema::create('discount_coupons', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('discount-percentage');
            $table->string('upto-amount');
            $table->string('max-amount')->nullable();
            $table->enum('status',['Active','Inactive'])->default('Active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_coupons');
    }
};
