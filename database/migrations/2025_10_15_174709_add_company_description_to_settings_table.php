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
        // Insert the company_description setting into the settings table
        \Modules\GlobalSetting\app\Models\Setting::create([
            'key' => 'company_description',
            'value' => 'Creating exceptional digital experiences through innovative design and strategic thinking.'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the company_description setting from the settings table
        \Modules\GlobalSetting\app\Models\Setting::where('key', 'company_description')->delete();
    }
};
