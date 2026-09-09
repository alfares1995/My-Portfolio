<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AboutMe;
use Inertia\Inertia;
use Inertia\Response;

class AboutMeController extends Controller
{
    public function index(): Response
    {
        $profile = AboutMe::query()->first();

        return Inertia::render('public/AboutMe/Index', [
            'profile' => [
                'fullName' => $profile?->full_name ?? '',
                'headline' => $profile?->headline ?? '',
                'shortBio' => $profile?->short_bio ?? '',
                'longBio' => $profile?->long_bio ?? '',
                'profileImage' => $profile?->profile_image_url,
                'bannerImage' => $profile?->banner_image_url,
                'resumeUrl' => $profile?->resume_url,
                'location' => $profile?->location,
                'email' => $profile?->email,
                'phone' => $profile?->phone,
                'availability' => $profile?->availability,
                'websiteUrl' => $profile?->website_url,
                'githubUrl' => $profile?->github_username ? "https://github.com/{$profile->github_username}" : null,
                'linkedinUrl' => $profile?->linkedin_url,
                'twitterUrl' => $profile?->twitter_url,
                'stats' => [
                    ['value' => $profile?->years_experience ?? 0, 'label' => 'Years Experience'],
                    ['value' => $profile?->projects_completed ?? 0, 'label' => 'Projects Completed'],
                    ['value' => $profile?->happy_clients ?? 0, 'label' => 'Happy Clients'],
                    ['value' => $profile?->cups_of_coffee ?? 0, 'label' => 'Cups of Coffee'],
                ],
            ],
        ]);
    }
}