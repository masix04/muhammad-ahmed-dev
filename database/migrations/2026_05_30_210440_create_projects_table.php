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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description');
            $table->longText('full_description')->nullable();
            $table->json('tech_tags')->nullable();          // ["Laravel","Livewire","MySQL"]
            $table->string('demo_video_url')->nullable();   // YouTube/Vimeo embed URL
            $table->string('github_url')->nullable();
            $table->string('live_url')->nullable();
            $table->string('thumbnail')->nullable();        // via spatie media library
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->string('category')->nullable();         // LMS, E-commerce, Sports, etc.
            $table->string('top_class')->nullable();              // for parallax positioning (0-100)
            $table->string('left_class')->nullable();             // for parallax positioning (0-100)
            $table->timestamps();
        });
    }
    public function down(): void 
    { 
        Schema::dropIfExists('projects');
    }
};
