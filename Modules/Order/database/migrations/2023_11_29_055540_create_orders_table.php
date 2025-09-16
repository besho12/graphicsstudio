<?php

use App\Models\User;
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
            $table->foreignIdFor(User::class)->constrained();
            $table->string('order_id');
            $table->integer('product_qty');

            $table->double('sub_total_usd')->default(0);
            $table->double('order_tax_usd')->default(0);
            $table->double('discount_usd')->default(0);
            $table->double('delivery_charge_usd')->default(0);
            $table->double('amount_usd')->default(0);
            
            $table->string('sub_total')->default(0);
            $table->string('order_tax')->default(0);
            $table->string('discount')->default(0);
            $table->string('delivery_charge')->default(0);
            $table->string('paid_amount');

            $table->string('gateway_charge')->nullable();
            $table->string('payable_with_charge')->nullable();
            $table->string('payable_currency')->nullable();
            
            $table->string('payment_method');
            $table->string('transaction_id')->nullable();
            $table->enum('payment_status', ['pending', 'success', 'rejected','refund'])->default('pending');
            $table->enum('order_status', ['draft','pending', 'process', 'success','refund','rejected'])->default('pending');
            $table->timestamps();
            $table->longText('payment_details')->nullable();
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
