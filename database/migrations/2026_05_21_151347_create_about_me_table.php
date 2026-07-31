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
        Schema::create('about_me', function (Blueprint $table) {
            $table->id();
             $table->string('full_name');

            $table->string('headline');
            // Example:
            // Full Stack Developer

            $table->text('short_bio');
            // Hero section short intro

            $table->longText('long_bio');
            // Full about me section

            $table->string('profile_image')
                ->nullable();

            $table->string('banner_image')
                ->nullable();

            $table->unsignedInteger('years_experience')
                ->default(0);

            $table->unsignedInteger('projects_completed')
                ->default(0);

            $table->unsignedInteger('happy_clients')
                ->default(0);

            $table->unsignedInteger('cups_of_coffee')
                ->default(0);

            $table->string('location')
                ->nullable();

            $table->string('email');

            $table->string('phone')
                ->nullable();

            $table->enum('availability', [
                'available',
                'busy',
                'freelancing',
                'not_available'
            ])->default('available');

            $table->string('resume_url')
                ->nullable();

            $table->string('github_username')
                ->nullable();

            $table->string('linkedin_url')
                ->nullable();

            $table->string('twitter_url')
                ->nullable();

            $table->string('website_url')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_me');
    }
};
