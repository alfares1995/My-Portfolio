<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Replaces the `resume_url` (external link) column with a `resume`
     * column that stores an uploaded PDF/Word file path, consistent with
     * how `profile_image` and `banner_image` are handled.
     */
    public function up(): void
    {
        Schema::table('about_me', function (Blueprint $table) {
            $table->renameColumn('resume_url', 'resume');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_me', function (Blueprint $table) {
            $table->renameColumn('resume', 'resume_url');
        });
    }
};
