<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BlogPost extends Model
{
    protected $appends = [
        'featured_image_url',
    ];

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'published_at',
        'status',
        'views',
        'seo_title',
        'seo_description',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function getFeaturedImageUrlAttribute(): ?string
    {
        return $this->featured_image ? Storage::disk('public')->url($this->featured_image) : null;
    }

    public function category()
    {
        return $this->belongsTo(
            BlogCategory::class,
            'category_id'
        );
    }

    public function tags()
    {
        return $this->belongsToMany(
            BlogTag::class,
            'blog_post_tag'
        );
    }
}
