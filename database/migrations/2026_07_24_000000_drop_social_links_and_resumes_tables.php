<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Drops the `social_links` and `resumes` tables. Both were unused stub
     * tables (no routes, controllers, or views wired up) that duplicated
     * data already fully managed on the `about_me` table
     * (linkedin_url, twitter_url, website_url, github_username, resume_url).
     */
    public function up(): void
    {
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('resumes');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('platform');
            $table->string('url');
            $table->string('icon')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('file');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }
};
