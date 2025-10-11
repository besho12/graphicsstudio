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
            $table->string('process_1_title')->nullable();
            $table->text('process_1_description')->nullable();
            $table->string('process_2_title')->nullable();
            $table->text('process_2_description')->nullable();
            $table->string('process_3_title')->nullable();
            $table->text('process_3_description')->nullable();
            $table->string('process_4_title')->nullable();
            $table->text('process_4_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_translations', function (Blueprint $table) {
            $table->dropColumn([
                'process_1_title',
                'process_1_description',
                'process_2_title',
                'process_2_description',
                'process_3_title',
                'process_3_description',
                'process_4_title',
                'process_4_description'
            ]);
        });
    }
};
