<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('my_role')->nullable()->after('category');   // "Backend developer in a team of 4"
            $table->text('challenge')->nullable()->after('full_description'); // the problem
            $table->text('solution')->nullable()->after('challenge');          // what I built
            $table->text('outcome')->nullable()->after('solution');            // the result
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['my_role', 'challenge', 'solution', 'outcome']);
        });
    }
};
