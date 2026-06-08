<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Prompt;
use App\Services\AchievementService;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = auth()->user()
            ->collections()
            ->latest()
            ->get();

        return view('collections.index', compact('collections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        Collection::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
        ]);

        $user = auth()->user();

        if ($user->collections()->count() >= 1) {
            AchievementService::unlock($user, 'Collector');
        }

        return back()
            ->with('success', 'Collection created.');
    }

    public function show(Collection $collection)
    {
        $collection->load(['prompts.category', 'prompts.ratings']);

        return view('collections.show', compact('collection'));
    }

    public function addPrompt(Collection $collection, Prompt $prompt)
    {
        $collection->prompts()->syncWithoutDetaching($prompt->id);

        return back()->with('success', 'Prompt added to collection.');
    }
}
