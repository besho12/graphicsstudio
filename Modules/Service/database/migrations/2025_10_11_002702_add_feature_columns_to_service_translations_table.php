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
            $table->string('feature_1_title')->nullable();
            $table->text('feature_1_description')->nullable();
            $table->string('feature_1_highlight')->nullable();
            $table->string('feature_2_title')->nullable();
            $table->text('feature_2_description')->nullable();
            $table->string('feature_2_highlight')->nullable();
            $table->string('feature_3_title')->nullable();
            $table->text('feature_3_description')->nullable();
            $table->string('feature_3_highlight')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_translations', function (Blueprint $table) {
            $table->dropColumn([
                'feature_1_title',
                'feature_1_description',
                'feature_1_highlight',
                'feature_2_title',
                'feature_2_description',
                'feature_2_highlight',
                'feature_3_title',
                'feature_3_description',
                'feature_3_highlight',
            ]);
        });
    }
};
