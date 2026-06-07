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
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->string('company');
            $table->string('location')->nullable();
            $table->string('period');                       // "Jun 2024 – Dec 2025"
            $table->date('start_date');
            $table->date('end_date')->nullable();           // null = current
            $table->boolean('is_current')->default(false);
            $table->json('bullets')->nullable();            // ["Built X","Developed Y"]
            $table->json('sub_projects')->nullable();       // [{"name":"Forex","desc":"...","tags":[]}]
            $table->string('company_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_experiences');
    }
};
