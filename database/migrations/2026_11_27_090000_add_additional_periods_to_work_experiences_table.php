<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_experiences', function (Blueprint $table) {
            // Extra time periods for the same role, e.g. [{"period": "Nov 2026 – Present"}]
            $table->json('additional_periods')->nullable()->after('period');
        });
    }

    public function down(): void
    {
        Schema::table('work_experiences', function (Blueprint $table) {
            $table->dropColumn('additional_periods');
        });
    }
};
