<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Prompt;
use App\Services\AchievementService;

class FavoriteController extends Controller
{
    public function store(Prompt $prompt)
    {
        Favorite::create([
            'user_id' => auth()->id(),
            'prompt_id' => $prompt->id,
        ]);

        if ($prompt->user->totalFavorites() >= 50) {
            AchievementService::unlock(
                $prompt->user,
                'Popular Creator'
            );
        }

        $prompt->updateFeaturedStatus();

        return back()
            ->with('success', 'Added to favorites.');
    }

    public function destroy(Prompt $prompt)
    {
        Favorite::where([
            'user_id' => auth()->id(),
            'prompt_id' => $prompt->id,
        ])->delete();

        return back()
            ->with('success', 'Removed from favorites.');
    }

    public function index()
    {
        $favorites = Favorite::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('favorites.index', compact('favorites'));
    }
}
