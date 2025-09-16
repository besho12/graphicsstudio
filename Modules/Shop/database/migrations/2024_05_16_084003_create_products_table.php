<?php

use App\Models\Admin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Shop\app\Models\ProductCategory;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Admin::class)->constrained();
            $table->foreignIdFor(ProductCategory::class)->constrained();
            $table->text('slug');
            $table->string('sku')->nullable();
            $table->string('qty')->nullable()->default(10);
            $table->decimal('price')->default(0);
            $table->decimal('sale_price')->nullable();
            $table->string('image')->nullable();
            $table->bigInteger('views')->default(0);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_popular')->default(false);
            $table->text('tags')->nullable();
            $table->boolean('status')->default(0);
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
