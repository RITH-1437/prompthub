<?php

namespace App\Http\Controllers;

use App\Models\Prompt;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request, Prompt $prompt)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $prompt->ratings()->updateOrCreate(
            [
                'user_id' => auth()->id(),
            ],
            [
                'rating' => $request->rating,
            ]
        );

        $prompt->updateFeaturedStatus();

        return back()
            ->with('success', 'Rating submitted.');
    }
}
