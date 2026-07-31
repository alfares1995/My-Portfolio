<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with(['technologies'])->withCount('images')->latest()->get();

        return Inertia::render('admin/projects/Index', [
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/projects/Create', [
            'technologies' => Technology::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:projects,slug',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'github_url' => 'nullable|url|max:255',
            'live_url' => 'nullable|url|max:255',
            'featured' => 'boolean',
            'status' => 'required|in:draft,published',
            'completion_date' => 'nullable|date',
            'technologies' => 'nullable|array',
            'technologies.*' => 'exists:technologies,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validatedData['slug'] = $validatedData['slug'] ?? Str::slug($validatedData['title']);

        if ($request->hasFile('thumbnail')) {
            $validatedData['thumbnail'] = $request->file('thumbnail')->store('projects', 'public');
        }

        $technologies = $validatedData['technologies'] ?? [];
        unset($validatedData['technologies'], $validatedData['images']);

        $project = Project::create($validatedData);
        $project->technologies()->sync($technologies);

        foreach ($request->file('images', []) as $index => $image) {
            $project->images()->create([
                'image' => $image->store('projects', 'public'),
                'sort_order' => $index,
            ]);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return Inertia::render('admin/projects/Show', [
            'project' => $project->load(['technologies', 'images']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return Inertia::render('admin/projects/Edit', [
            'project' => $project->load(['technologies', 'images']),
            'technologies' => Technology::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('projects', 'slug')->ignore($project->id),
            ],
            'short_description' => 'required|string',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'github_url' => 'nullable|url|max:255',
            'live_url' => 'nullable|url|max:255',
            'featured' => 'boolean',
            'status' => 'required|in:draft,published',
            'completion_date' => 'nullable|date',
            'technologies' => 'nullable|array',
            'technologies.*' => 'exists:technologies,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:project_images,id',
        ]);

        $validatedData['slug'] = $validatedData['slug'] ?? Str::slug($validatedData['title']);

        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }
            $validatedData['thumbnail'] = $request->file('thumbnail')->store('projects', 'public');
        } else {
            unset($validatedData['thumbnail']);
        }

        $technologies = $validatedData['technologies'] ?? [];
        $deleteImageIds = $validatedData['delete_images'] ?? [];
        unset($validatedData['technologies'], $validatedData['images'], $validatedData['delete_images']);

        $project->update($validatedData);
        $project->technologies()->sync($technologies);

        if (! empty($deleteImageIds)) {
            $imagesToDelete = ProjectImage::whereKey($deleteImageIds)->where('project_id', $project->id)->get();
            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->image);
                $image->delete();
            }
        }

        $nextSortOrder = $project->images()->max('sort_order') + 1;
        foreach ($request->file('images', []) as $index => $image) {
            $project->images()->create([
                'image' => $image->store('projects', 'public'),
                'sort_order' => $nextSortOrder + $index,
            ]);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }

        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->image);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }
}
