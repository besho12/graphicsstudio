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
        Schema::table('service_translations', function (Blueprint $table) {
            $table->string('benefit_1_title')->nullable();
            $table->text('benefit_1_description')->nullable();
            $table->string('benefit_2_title')->nullable();
            $table->text('benefit_2_description')->nullable();
            $table->string('benefit_3_title')->nullable();
            $table->text('benefit_3_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_translations', function (Blueprint $table) {
            $table->dropColumn([
                'benefit_1_title',
                'benefit_1_description',
                'benefit_2_title',
                'benefit_2_description',
                'benefit_3_title',
                'benefit_3_description'
            ]);
        });
    }
};
