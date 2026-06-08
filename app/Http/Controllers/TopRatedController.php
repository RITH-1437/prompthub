<?php

namespace App\Http\Controllers;

use App\Models\Prompt;

class TopRatedController extends Controller
{
    public function index()
    {
        $prompts = Prompt::withCount([
            'favorites',
            'comments',
            'ratings',
        ])
            ->withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating')
            ->paginate(12);

        return view(
            'top-rated.index',
            compact('prompts')
        );
    }
}
