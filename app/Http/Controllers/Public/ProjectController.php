<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Welcome', [
            'projects' => Project::query()->latest()->paginate(12),
        ]);
    }

    public function show(Project $project): Response
    {
        return Inertia::render('Welcome', [
            'project' => $project->load(['images', 'technologies']),
        ]);
    }
}
