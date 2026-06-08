<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Prompt;
use App\Models\Tag;
use App\Services\AchievementService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromptController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $prompts = Prompt::where('user_id', $userId)
            ->withCount(['favorites', 'comments'])
            ->with(['ratings' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])
            ->latest()
            ->get();

        return view('prompts.index', compact('prompts'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('prompts.create', compact('categories'));
    }

    public function show($identifier)
    {
        $prompt = Prompt::where('id', $identifier)
            ->orWhere('slug', $identifier)
            ->firstOrFail();

        if ((string) $prompt->id !== (string) $identifier) {
            return redirect()->route('prompts.show', $prompt->id);
        }

        $prompt->increment('views_count');
        $prompt->load(['ratings' => function ($query) {
            $query->where('user_id', auth()->id());
        }]);

        return view('prompts.show', compact('prompt'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required',
        ]);

        $prompt = Prompt::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'prompt_content' => $request->content,
        ]);

        $user = auth()->user();

        if ($user->prompts()->count() >= 1) {
            AchievementService::unlock($user, 'First Prompt');
        }

        if ($user->prompts()->count() >= 10) {
            AchievementService::unlock($user, 'Prompt Master');
        }

        $tags = explode(',', $request->tags);

        foreach ($tags as $tagName) {

            $tag = Tag::firstOrCreate([
                'name' => trim($tagName),
            ]);

            $prompt->tags()->attach($tag->id);

        }

        return redirect('/prompts')
            ->with('success', 'Prompt created successfully.');
    }

    public function edit(Prompt $prompt)
    {
        $categories = Category::all();

        return view('prompts.edit', compact('prompt', 'categories'));
    }

    public function update(Request $request, Prompt $prompt)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required',
        ]);

        $prompt->update([
            'title' => $request->title,
            'prompt_content' => $request->content,
            'category_id' => $request->category_id,
        ]);

        return redirect('/prompts')
            ->with('success', 'Prompt updated successfully.');
    }

    public function destroy(Prompt $prompt)
    {
        $prompt->delete();

        return redirect('/prompts')
            ->with('success', 'Prompt deleted successfully.');
    }

    public function explore(Request $request)
    {
        $search = $request->search;
        $sort = $request->sort ?? 'trending';
        $userId = auth()->id();

        $query = Prompt::with(['user', 'category', 'tags'])
            ->orderByDesc('is_featured');
        $query->with(['ratings' => function ($q) use ($userId) {
            $q->where('user_id', $userId);
        }]);

        if ($search) {

            $query->where(function ($q) use ($search) {

                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('prompt_content', 'like', "%{$search}%");

            });

        }

        switch ($sort) {

            case 'newest':
                $query->latest();
                break;

            case 'views':
                $query->orderByDesc('views_count');
                break;

            case 'copies':
                $query->orderByDesc('copy_count');
                break;

            default:
                $query->orderByDesc('views_count');
                break;
        }

        $prompts = $query->get();

        return view(
            'explore.index',
            compact('prompts', 'search', 'sort')
        );
    }

    public function incrementCopy(Prompt $prompt)
    {
        $prompt->increment('copy_count');

        return response()->json([
            'success' => true,
            'new_count' => $prompt->fresh()->copy_count,
        ]);

        $user = $prompt->user;

        $totalCopies = $user->prompts()->sum('views_count');

        if ($totalCopies >= 100) {
            AchievementService::unlock(
                $user,
                'Copy King'
            );
        }
    }
}
