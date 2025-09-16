<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Subscription\app\Models\SubscriptionPlan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscription_plan_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SubscriptionPlan::class)->constrained()->cascadeOnDelete();
            $table->string('lang_code');
            $table->string('plan_name');
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('button_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plan_translations');
    }
};
