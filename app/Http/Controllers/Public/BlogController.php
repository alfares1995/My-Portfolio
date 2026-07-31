<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Inertia\Inertia;
use Inertia\Response;

class BlogController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Welcome', [
            'posts' => BlogPost::query()
                ->with(['category', 'tags'])
                ->latest('published_at')
                ->paginate(10),
        ]);
    }

    public function show(BlogPost $post): Response
    {
        return Inertia::render('Welcome', [
            'post' => $post->load(['category', 'tags']),
        ]);
    }
}
