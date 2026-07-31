<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    protected $appends = [
        'thumbnail_url',
    ];

     protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'thumbnail',
        'github_url',
        'live_url',
        'featured',
        'status',
        'completion_date',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'completion_date' => 'date',
    ];

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail ? Storage::disk('public')->url($this->thumbnail) : null;
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class);
    }

    public function technologies()
    {
        return $this->belongsToMany(
            Technology::class,
            'project_technology'
        );
    }
}
