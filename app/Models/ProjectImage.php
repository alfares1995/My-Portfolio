<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProjectImage extends Model
{
    protected $appends = [
        'image_url',
    ];

    protected $fillable = [
        'project_id',
        'image',
        'caption',
        'sort_order',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
