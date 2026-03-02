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
        Schema::table('ab_article', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.cache
     */
    public function down(): void
    {
        Schema::table('ab_article', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }
};
