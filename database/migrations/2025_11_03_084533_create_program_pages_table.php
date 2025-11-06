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
        Schema::create('program_pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_bur');
            $table->string('cover_url');
            $table->longText('description');
            $table->longText('description_bur');
            $table->longText('reason');
            $table->longText('reason_bur');
            $table->longText('content');
            $table->longText('content_bur');
            $table->string('img_url')->nullable();
            $table->longText('quote');
            $table->longText('quote_bur');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_pages');
    }
};
