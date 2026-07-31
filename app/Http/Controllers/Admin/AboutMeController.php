<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutMe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Inertia\Inertia;

class AboutMeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $aboutMeData = AboutMe::all();
        return Inertia::render('admin/about-me/Index', [
            'aboutMeData' => $aboutMeData,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return Inertia::render('admin/about-me/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'headline' => 'required|string|max:255',
            'short_bio' => 'required|string|max:500',
            'long_bio' => 'required|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'years_experience' => 'required|integer|min:0',
            'projects_completed' => 'required|integer|min:0',
            'happy_clients' => 'required|integer|min:0',
            'cups_of_coffee' => 'required|integer|min:0',
            'location' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'availability' => 'nullable|string|max:255',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'github_username' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'website_url' => 'nullable|url|max:255',
        ]);


        if ($request->hasFile('profile_image')) {
            $validatedData['profile_image'] = $request->file('profile_image')->store('about-me', 'public');
        }

        if ($request->hasFile('banner_image')) {
            $validatedData['banner_image'] = $request->file('banner_image')->store('about-me', 'public');
        }

        if ($request->hasFile('resume')) {
            $validatedData['resume'] = $request->file('resume')->store('about-me/resumes', 'public');
        }

        AboutMe::create($validatedData);
        return redirect()->route('admin.about-me.index')->with('success', 'About Me entry created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AboutMe $aboutMe)
    {
        //
        return Inertia::render('admin/about-me/Show', [
            'aboutMe' => $aboutMe,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AboutMe $aboutMe)
    {
        //
        return Inertia::render('admin/about-me/Edit', [
            'aboutMe' => $aboutMe,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AboutMe $aboutMe)
    {
        //
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'headline' => 'required|string|max:255',
            'short_bio' => 'required|string|max:500',
            'long_bio' => 'required|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'years_experience' => 'required|integer|min:0',
            'projects_completed' => 'required|integer|min:0',
            'happy_clients' => 'required|integer|min:0',
            'cups_of_coffee' => 'required|integer|min:0',
            'location' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'availability' => 'nullable|string|max:255',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'github_username' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'website_url' => 'nullable|url|max:255',
        ]);

        if ($request->hasFile('profile_image')) {
            if ($aboutMe->profile_image) {
                Storage::disk('public')->delete($aboutMe->profile_image);
            }
            $validatedData['profile_image'] = $request->file('profile_image')->store('about-me', 'public');
        } else {
            unset($validatedData['profile_image']);
        }

        if ($request->hasFile('banner_image')) {
            if ($aboutMe->banner_image) {
                Storage::disk('public')->delete($aboutMe->banner_image);
            }
            $validatedData['banner_image'] = $request->file('banner_image')->store('about-me', 'public');
        } else {
            unset($validatedData['banner_image']);
        }

        if ($request->hasFile('resume')) {
            if ($aboutMe->resume) {
                Storage::disk('public')->delete($aboutMe->resume);
            }
            $validatedData['resume'] = $request->file('resume')->store('about-me/resumes', 'public');
        } else {
            unset($validatedData['resume']);
        }

        $aboutMe->update($validatedData);

        return redirect()->route('admin.about-me.index')->with('success', 'About Me entry updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AboutMe $aboutMe)
    {
        foreach (['profile_image', 'banner_image', 'resume'] as $field) {
            if ($aboutMe->{$field}) {
                Storage::disk('public')->delete($aboutMe->{$field});
            }
        }

        $aboutMe->delete();

        return redirect()->route('admin.about-me.index')->with('success', 'About Me entry deleted successfully.');
    }
}
