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
        Schema::table('ives_metadata', function (Blueprint $table) {
            $table->string('filename')->nullable()->after('size');
            $table->string('filetype')->nullable()->after('filename');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ives_metadata', function (Blueprint $table) {
            $table->dropColumn('filename');
            $table->dropColumn('filetype');
        });
    }
};
