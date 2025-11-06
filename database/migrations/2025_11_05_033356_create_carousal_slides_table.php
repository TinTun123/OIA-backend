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
        Schema::create('carousal_slides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carousal_id')->constrained()->cascadeOnDelete();
            $table->longText('description')->nullable();
            $table->longText('description_bur')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('sort_order')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carousal_slides');
    }
};
