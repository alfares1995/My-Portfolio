<?php

use App\Models\Project;
use App\Models\Technology;
use Inertia\Testing\AssertableInertia as Assert;

test('published projects can be filtered by technology', function () {
    $laravel = Technology::create(['name' => 'Laravel']);
    $vue = Technology::create(['name' => 'Vue']);

    $matchingProject = Project::create([
        'title' => 'Laravel Project',
        'slug' => 'laravel-project',
        'short_description' => 'A Laravel application.',
        'description' => 'Project description.',
        'status' => 'published',
    ]);
    $matchingProject->technologies()->attach($laravel);

    $otherProject = Project::create([
        'title' => 'Vue Project',
        'slug' => 'vue-project',
        'short_description' => 'A Vue application.',
        'description' => 'Project description.',
        'status' => 'published',
    ]);
    $otherProject->technologies()->attach($vue);

    Project::create([
        'title' => 'Draft Project',
        'slug' => 'draft-project',
        'short_description' => 'A draft application.',
        'description' => 'Project description.',
        'status' => 'draft',
    ]);

    $this->get(route('projects.index', ['technology' => 'Laravel']))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('public/projects/Index')
            ->where('filters.technology', 'Laravel')
            ->has('projects', 1)
            ->where('projects.0.slug', $matchingProject->slug)
            ->has('technologies', 2)
            ->where('technologies.0.name', 'Laravel')
        );
});

test('draft projects are not publicly visible', function () {
    $project = Project::create([
        'title' => 'Draft Project',
        'slug' => 'draft-project',
        'short_description' => 'A draft application.',
        'description' => 'Project description.',
        'status' => 'draft',
    ]);

    $this->get(route('projects.show', $project))->assertNotFound();
});