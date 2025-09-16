<?php

use App\Models\User;
use App\Models\Admin;
use Modules\Shop\app\Models\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignIdFor(User::class)->nullable()->default(0);
            $table->foreignIdFor(Product::class)->constrained();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->text('review');
            $table->string('rating')->nullable()->default(0);
            $table->foreignIdFor(Admin::class)->nullable()->default(0);
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};
