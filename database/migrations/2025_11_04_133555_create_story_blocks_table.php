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
        Schema::create('story_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')
                ->constrained('stories')
                ->cascadeOnDelete();

            $table->enum('type', ['text', 'image_quote']);
            $table->longText('text')->nullable();
            $table->longText('text_bur')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('story_blocks');
    }
};
