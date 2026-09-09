<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index(Request $request): Response
    {
        $technology = $request->string('technology')->toString();

        $projects = Project::query()
            ->where('status', 'published')
            ->with('technologies')
            ->when($technology, fn ($query) => $query->whereHas(
                'technologies',
                fn ($query) => $query->where('technologies.name', $technology)
            ))
            ->latest('completion_date')
            ->get();

        return Inertia::render('public/projects/Index', [
            'projects' => $projects,
            'technologies' => Technology::query()
                ->whereHas('projects', fn ($query) => $query->where('status', 'published'))
                ->orderBy('name')
                ->get(['id', 'name', 'color']),
            'filters' => [
                'technology' => $technology ?: null,
            ],
        ]);
    }

    public function show(Project $project): Response
    {
        abort_unless($project->status === 'published', 404);

        $project->load([
            'images' => fn ($query) => $query->orderBy('sort_order'),
            'technologies',
        ]);

        return Inertia::render('public/projects/Show', [
            'project' => [
                ...$project->toArray(),
                'completion_date_label' => $project->completion_date?->format('F Y'),
            ],
        ]);
    }
}
