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
        Schema::table('posts', function (Blueprint $table) {
            //
            $table->enum('type', [
                'Food Security',
                'Emergency Response',
                'Training',
                'Health & Education',
                'Advocacy',
                'Organizational Development'
            ])->nullable()->after('images');

            $table->string('fbURL')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            //
            $table->dropColumn(['type', 'fbURL']);
        });
    }
};
