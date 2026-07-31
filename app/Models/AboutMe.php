<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AboutMe extends Model
{
    protected $table = 'about_me';

    protected $appends = [
        'profile_image_url',
        'banner_image_url',
        'resume_url',
    ];

    protected $fillable = [
        'full_name',
        'headline',
        'short_bio',
        'long_bio',
        'profile_image',
        'banner_image',
        'years_experience',
        'projects_completed',
        'happy_clients',
        'cups_of_coffee',
        'location',
        'email',
        'phone',
        'availability',
        'resume',
        'github_username',
        'linkedin_url',
        'twitter_url',
        'website_url',
    ];

    public function getProfileImageUrlAttribute(): ?string
    {
        return $this->profile_image ? Storage::disk('public')->url($this->profile_image) : null;
    }

    public function getBannerImageUrlAttribute(): ?string
    {
        return $this->banner_image ? Storage::disk('public')->url($this->banner_image) : null;
    }

    public function getResumeUrlAttribute(): ?string
    {
        return $this->resume ? Storage::disk('public')->url($this->resume) : null;
    }
}
