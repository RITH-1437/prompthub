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
            ->withCount('prompts')
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
        $this->authorizeOwner($collection);

        $collection->load('prompts.category');

        return view('collections.show', compact('collection'));
    }

    public function addPrompt(Collection $collection, Prompt $prompt)
    {
        $this->authorizeOwner($collection);

        $collection->prompts()->syncWithoutDetaching($prompt->id);

        return back()->with('success', 'Prompt added to collection.');
    }

    public function destroy(Collection $collection)
    {
        $this->authorizeOwner($collection);

        $collection->delete();

        return redirect()
            ->route('collections.index')
            ->with('success', 'Collection deleted.');
    }

    private function authorizeOwner(Collection $collection): void
    {
        abort_unless($collection->user_id === auth()->id(), 403);
    }
}
