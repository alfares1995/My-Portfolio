<?php

namespace App\Http\Middleware;

use App\Models\AboutMe;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $request->user(),
            ],
            'profile' => function (): array {
                $profile = AboutMe::query()->first();

                return [
                    'fullName' => $profile?->full_name ?? '',
                    'githubUrl' => $profile?->github_username ? "https://github.com/{$profile->github_username}" : null,
                    'phone' => $profile?->phone,
                    'linkedinUrl' => $profile?->linkedin_url,
                    'twitterUrl' => $profile?->twitter_url,
                    'email' => $profile?->email,
                    'location' => $profile?->location,
                ];
            },
            'currentYear' => now()->year,
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
        ];
    }
}
