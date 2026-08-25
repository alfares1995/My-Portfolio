<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AboutMe;
use App\Models\BlogPost;
use App\Models\Project;
use App\Models\Skill;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $profile = AboutMe::query()->first();

        return Inertia::render('public/Home', [
            'profile' => [
                'firstName' => str($profile?->full_name ?? '')->beforeLast(' ')->toString(),
                'lastName' => str($profile?->full_name ?? '')->afterLast(' ')->toString(),
                'role' => $profile?->headline ?? '',
                'tagline' => $profile?->short_bio ?? '',
                'longBio' => $profile?->long_bio ?? '',
                'avatar' => $profile?->profile_image_url,
                'banner' => $profile?->banner_image_url,
                'social' => collect([
                    ['icon' => 'github', 'url' => $profile?->github_username ? "https://github.com/{$profile->github_username}" : null],
                    ['icon' => 'phone', 'url' => $profile?->phone ? "tel:{$profile->phone}" : null],
                    ['icon' => 'linkedin', 'url' => $profile?->linkedin_url],
                    ['icon' => 'twitter', 'url' => $profile?->twitter_url],
                    ['icon' => 'mail', 'url' => $profile?->email ? "mailto:{$profile->email}" : null],
                    ['icon' => 'map', 'url' => $profile?->location],
                ])->filter(fn (array $social) => filled($social['url']))->values(),
                'stats' => [
                    ['icon' => 'rocket', 'value' => $profile?->years_experience ?? 0, 'label' => 'Years Experience'],
                    ['icon' => 'code', 'value' => $profile?->projects_completed ?? 0, 'label' => 'Projects Completed'],
                    ['icon' => 'heart', 'value' => $profile?->happy_clients ?? 0, 'label' => 'Happy Clients'],
                    ['icon' => 'coffee', 'value' => $profile?->cups_of_coffee ?? 0, 'label' => 'Cups of Coffee'],
                ],
            ],
            'trustedBy' => [],
            'projects' => Project::query()
                ->with('technologies')
                ->latest()
                ->take(6)
                ->get()
                ->map(fn (Project $project) => [
                    'title' => $project->title,
                    'description' => $project->short_description,
                    'image' => $project->thumbnail_url,
                    'tags' => $project->technologies->pluck('name'),
                    'repoUrl' => $project->github_url,
                    'liveUrl' => $project->live_url,
                ]),
            'posts' => BlogPost::query()
                ->with(['category', 'tags'])
                ->latest('published_at')
                ->take(3)
                ->get()
                ->map(fn (BlogPost $post) => [
                    'title' => $post->title,
                    'image' => $post->featured_image_url,
                    'date' => $post->published_at?->format('M j, Y'),
                    'excerpt' => $post->excerpt,
                    'readTime' => '',
                    'url' => route('blog.show', $post),
                ]),
            'skills' => Skill::query()
                ->orderBy('sort_order')
                ->get()
                ->map(fn (Skill $skill) => [
                    'name' => $skill->name,
                    'level' => $skill->percentage,
                ]),
        ]);
    }
}
