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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('total_amount', 10, 2);
            $table->double('shipping', 10,2)->nullable();
            $table->integer('coupon_id')->nullable();
            $table->string('coupon_code')->nullable();
            $table->double('discount', 10, 2)->nullable();
            $table->double('grand_total',10,2);
            $table->enum('payment_method',['prepaid'])->nullable();
            $table->enum('payment_status',['paid','not paid'])->default('not paid');
            $table->string('payment_id')->nullable();
            $table->enum('status',['pending','shipped','delivered','cancelled','processing'])->default('pending');
            $table->timestamp('shipped_date')->nullable();
            $table->string('courier_company')->nullable();
            $table->string('tracking_id')->nullable();
            $table->timestamp('delivery_date')->nullable();
            $table->string( 'name');
            $table->string('email');
            $table->string('phone');
            $table->string('country')->default('India');
            $table->text('address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};