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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id')->default(0);
            $table->string('coupon_code');
            $table->decimal('min_price', 8, 2);
            $table->decimal('discount', 8, 2);
            $table->enum('discount_type', ['percentage','amount'])->default('percentage');
            $table->string('start_date');
            $table->string('expired_date');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
