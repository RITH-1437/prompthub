<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    public function show(User $user)
    {
        $user->load([
            'followers',
            'following',
        ]);

        $prompts = $user->prompts()
            ->with(['category'])
            ->withCount('comments')
            ->latest()
            ->get();

        $totalViews = (int) $user->prompts()->sum('views_count');

        $totalCopies = (int) $user->prompts()->sum('copy_count');

        return view('profile.show', compact(
            'user',
            'prompts',
            'totalViews',
            'totalCopies'
        ));
    }
}
