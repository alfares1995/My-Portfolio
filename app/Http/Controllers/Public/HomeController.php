<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Project;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{


    public function index(): Response
    {
        return Inertia::render('public/Home'
        , [
            'projects' => Project::query()->latest()->take(6)->get(),
            'posts' => BlogPost::query()
                ->with(['category', 'tags'])
                ->latest('published_at')
                ->take(3)
                ->get(),
        ]);
        
    }
}
