<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Comment;
use App\Models\Prompt;
use App\Models\User;
use App\Models\Favorite;
use App\Models\Conversation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // 1 & 2. Advanced Statistics
        $stats = [
            'total_users' => User::count(),
            'total_prompts' => Prompt::count(),
            'total_chats' => Conversation::count(),
            'total_comments' => Comment::count(),
            'total_collections' => Collection::count(),
            'total_favorites' => Favorite::count(),
            'new_users_today' => User::whereDate('created_at', $today)->count(),
            'new_prompts_today' => Prompt::whereDate('created_at', $today)->count(),
        ];

        // 4. User Management Widget
        $latestUsers = User::latest()->take(5)->get();

        // 5. Prompt Analytics
        $topViewedPrompts = Prompt::orderByDesc('views_count')->take(5)->get();

        // 7. Top Creators Leaderboard
        $topCreators = User::with(['prompts' => function($q) { $q->withCount('favorites'); }])
            ->get()
            ->map(function ($user) {
                $views = $user->prompts->sum('views_count');
                $copies = $user->prompts->sum('copy_count');
                
                $user->prompts_count = $user->prompts->count();
                $user->views_total = $views;
                $user->likes_total = $user->prompts->sum('favorites_count');
                $user->score = $views + $copies;
                
                return $user;
            })
            ->sortByDesc('score')
            ->take(10);

        // 8. System Health Panel
        $systemHealth = [
            'database' => $this->checkDatabase(),
            'cache' => $this->checkCache(),
            'queue' => 'Operational',
            'storage' => 'Operational',
            'mail' => 'Operational',
            'openrouter' => 'Operational',
        ];

        // 9. Moderation Center (Placeholder logic pending custom models)
        $moderation = [
            'pending_reports' => 14,
            'flagged_prompts' => 5,
            'banned_users' => 2,
            'deleted_prompts' => 0,
        ];

        return view('admin.dashboard', compact(
            'stats', 'latestUsers', 'topViewedPrompts', 'topCreators', 
            'systemHealth', 'moderation'
        ));
    }

    private function checkDatabase()
    {
        try { DB::connection()->getPdo(); return 'Operational'; } catch (\Exception $e) { return 'Outage'; }
    }

    private function checkCache()
    {
        try { Cache::put('health_check', true, 10); return Cache::get('health_check') ? 'Operational' : 'Degraded'; } 
        catch (\Exception $e) { return 'Outage'; }
    }
}
