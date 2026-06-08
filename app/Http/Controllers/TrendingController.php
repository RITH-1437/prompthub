<?php

namespace App\Http\Controllers;

use App\Models\Prompt;

class TrendingController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $prompts = Prompt::with(['category', 'tags'])
            ->with(['ratings' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])
            ->orderBy('views_count', 'desc')
            ->paginate(10);

        return view('trending.index', compact('prompts'));
    }
}
