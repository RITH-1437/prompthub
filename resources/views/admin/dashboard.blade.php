@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-12 font-sans">

    <!-- 1. Dashboard Overview / Hero Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 to-slate-800 p-8 border border-slate-700/50 shadow-2xl">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-5">
                <img src="{{ asset('images/logo.png') }}" alt="PromptHub Logo" class="w-16 h-16 rounded-2xl shadow-lg shadow-violet-500/30">
                <div>
                    <h1 class="text-3xl font-extrabold text-white tracking-tight mb-1">
                        Welcome back, {{ auth()->user()->name }}
                    </h1>
                    <p class="text-slate-400 text-sm">Monitor platform metrics, manage users, and configure PromptHub.</p>
                </div>
            </div>
            <div class="flex flex-col items-end gap-2">
                <div class="flex items-center gap-3 bg-slate-950/50 px-4 py-2 rounded-xl border border-slate-700/50 backdrop-blur-md">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                    </span>
                    <span class="text-sm font-medium text-slate-200">Platform Operational</span>
                </div>
                <span class="text-xs text-slate-500">Last login: Today, {{ now()->format('h:i A') }}</span>
            </div>
        </div>
        
        <!-- Decorative glows -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 rounded-full bg-violet-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-fuchsia-500/10 blur-3xl"></div>
    </div>

    <!-- 2. Advanced Statistics Cards -->
    @php
        $cards = [
            ['title' => 'Total Users', 'value' => $stats['total_users'], 'icon' => 'users', 'bg' => 'bg-blue-500/10', 'hover_bg' => 'group-hover:bg-blue-500/20', 'border' => 'border-blue-500/20', 'text' => 'text-blue-400', 'shadow' => 'hover:shadow-blue-500/10', 'trend' => '+12%'],
            ['title' => 'Total Prompts', 'value' => $stats['total_prompts'], 'icon' => 'file-text', 'bg' => 'bg-violet-500/10', 'hover_bg' => 'group-hover:bg-violet-500/20', 'border' => 'border-violet-500/20', 'text' => 'text-violet-400', 'shadow' => 'hover:shadow-violet-500/10', 'trend' => '+24%'],
            ['title' => 'AI Generations', 'value' => $stats['total_chats'], 'icon' => 'sparkles', 'bg' => 'bg-fuchsia-500/10', 'hover_bg' => 'group-hover:bg-fuchsia-500/20', 'border' => 'border-fuchsia-500/20', 'text' => 'text-fuchsia-400', 'shadow' => 'hover:shadow-fuchsia-500/10', 'trend' => '+18%'],
            ['title' => 'Comments', 'value' => $stats['total_comments'], 'icon' => 'message-square', 'bg' => 'bg-emerald-500/10', 'hover_bg' => 'group-hover:bg-emerald-500/20', 'border' => 'border-emerald-500/20', 'text' => 'text-emerald-400', 'shadow' => 'hover:shadow-emerald-500/10', 'trend' => '+8%'],
            ['title' => 'Collections', 'value' => $stats['total_collections'], 'icon' => 'folder', 'bg' => 'bg-amber-500/10', 'hover_bg' => 'group-hover:bg-amber-500/20', 'border' => 'border-amber-500/20', 'text' => 'text-amber-400', 'shadow' => 'hover:shadow-amber-500/10', 'trend' => '+5%'],
            ['title' => 'Total Favorites', 'value' => $stats['total_favorites'], 'icon' => 'heart', 'bg' => 'bg-rose-500/10', 'hover_bg' => 'group-hover:bg-rose-500/20', 'border' => 'border-rose-500/20', 'text' => 'text-rose-400', 'shadow' => 'hover:shadow-rose-500/10', 'trend' => '+32%'],
            ['title' => 'New Users Today', 'value' => $stats['new_users_today'], 'icon' => 'user-plus', 'bg' => 'bg-cyan-500/10', 'hover_bg' => 'group-hover:bg-cyan-500/20', 'border' => 'border-cyan-500/20', 'text' => 'text-cyan-400', 'shadow' => 'hover:shadow-cyan-500/10', 'trend' => 'Today'],
            ['title' => 'New Prompts Today', 'value' => $stats['new_prompts_today'], 'icon' => 'zap', 'bg' => 'bg-indigo-500/10', 'hover_bg' => 'group-hover:bg-indigo-500/20', 'border' => 'border-indigo-500/20', 'text' => 'text-indigo-400', 'shadow' => 'hover:shadow-indigo-500/10', 'trend' => 'Today'],
        ];
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach($cards as $card)
            <div class="group relative bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-2xl p-6 hover:bg-slate-800/60 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl {{ $card['shadow'] }} overflow-hidden cursor-default">
                <!-- Background gradient flare -->
                <div class="absolute -top-10 -right-10 w-32 h-32 {{ $card['bg'] }} rounded-full blur-2xl {{ $card['hover_bg'] }} transition-colors"></div>
                
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div class="p-3 {{ $card['bg'] }} rounded-xl border {{ $card['border'] }} {{ $card['text'] }}">
                        <i data-lucide="{{ $card['icon'] }}" class="w-5 h-5"></i>
                    </div>
                    <span class="flex items-center text-emerald-400 text-xs font-semibold bg-emerald-400/10 px-2 py-1 rounded-lg">
                        @if($card['trend'] !== 'Today') <i data-lucide="trending-up" class="w-3 h-3 mr-1"></i> @endif
                        {{ $card['trend'] }}
                    </span>
                </div>
                <p class="text-slate-400 text-sm font-medium mb-1 relative z-10">{{ $card['title'] }}</p>
                <h3 class="text-3xl font-bold text-white tracking-tight relative z-10">{{ number_format($card['value']) }}</h3>
            </div>
        @endforeach
    </div>

    <!-- Activity Feed (Full Row) -->
    <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-2xl p-6 shadow-lg overflow-hidden">
        <h3 class="text-base font-semibold text-white mb-6 flex items-center gap-2">
            <i data-lucide="activity" class="w-5 h-5 text-rose-400"></i> Activity Feed
        </h3>
        <div class="flex flex-row gap-6 overflow-x-auto pb-4 scrollbar-hide">
            
            <!-- Mock Timeline Item 1 -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 min-w-[300px] p-4 rounded-xl border border-slate-700/50 bg-slate-800/30 shrink-0">
                <div class="flex items-center justify-center w-12 h-12 rounded-full border border-slate-700 bg-slate-800 text-emerald-400 shrink-0 shadow">
                    <i data-lucide="user-plus" class="w-5 h-5"></i>
                </div>
                <div class="flex-1 w-full">
                    <div class="flex items-center justify-between mb-1">
                        <span class="font-semibold text-slate-200 text-sm">New Registration</span>
                        <span class="text-xs text-slate-500 whitespace-nowrap ml-2">2 min ago</span>
                    </div>
                    <p class="text-xs text-slate-400">Sarah Jenkins joined the platform.</p>
                </div>
            </div>

            <!-- Mock Timeline Item 2 -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 min-w-[300px] p-4 rounded-xl border border-slate-700/50 bg-slate-800/30 shrink-0">
                <div class="flex items-center justify-center w-12 h-12 rounded-full border border-slate-700 bg-slate-800 text-violet-400 shrink-0 shadow">
                    <i data-lucide="file-plus" class="w-5 h-5"></i>
                </div>
                <div class="flex-1 w-full">
                    <div class="flex items-center justify-between mb-1">
                        <span class="font-semibold text-slate-200 text-sm">Prompt Created</span>
                        <span class="text-xs text-slate-500 whitespace-nowrap ml-2">15 min ago</span>
                    </div>
                    <p class="text-xs text-slate-400">Alex_Dev created 'Laravel AI Setup'.</p>
                </div>
            </div>

            <!-- Mock Timeline Item 3 -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 min-w-[300px] p-4 rounded-xl border border-slate-700/50 bg-slate-800/30 shrink-0">
                <div class="flex items-center justify-center w-12 h-12 rounded-full border border-slate-700 bg-slate-800 text-blue-400 shrink-0 shadow">
                    <i data-lucide="message-square" class="w-5 h-5"></i>
                </div>
                <div class="flex-1 w-full">
                    <div class="flex items-center justify-between mb-1">
                        <span class="font-semibold text-slate-200 text-sm">New Comment</span>
                        <span class="text-xs text-slate-500 whitespace-nowrap ml-2">1 hr ago</span>
                    </div>
                    <p class="text-xs text-slate-400">Mike commented on your prompt.</p>
                </div>
            </div>

        </div>
    </div>

    <!-- Middle Section: User Management -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">

            <!-- 4. User Management Widget -->
            <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-2xl overflow-hidden shadow-lg">
                <div class="p-6 border-b border-slate-700/50 flex justify-between items-center bg-slate-800/30">
                    <h3 class="text-base font-semibold text-white flex items-center gap-2">
                        <i data-lucide="users-2" class="w-5 h-5 text-indigo-400"></i> Recent Registrations
                    </h3>
                    <a href="/admin/users" class="text-sm font-medium text-indigo-400 hover:text-indigo-300 transition-colors">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-slate-400 bg-slate-800/50 uppercase">
                            <tr>
                                <th class="px-6 py-4 font-medium">User</th>
                                <th class="px-6 py-4 font-medium">Role</th>
                                <th class="px-6 py-4 font-medium">Joined</th>
                                <th class="px-6 py-4 text-right font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($latestUsers as $user)
                                <tr class="hover:bg-slate-800/30 transition-colors">
                                    <td class="px-6 py-4 flex items-center gap-3">
                                        <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name ?? 'User').'&background=random' }}" class="w-8 h-8 rounded-full border border-slate-600">
                                        <div>
                                            <p class="font-medium text-slate-200">{{ $user->name }}</p>
                                            <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($user->is_admin)
                                            <span class="bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 px-2.5 py-1 rounded-md text-xs font-medium">Admin</span>
                                        @else
                                            <span class="bg-slate-700/30 text-slate-400 border border-slate-600/30 px-2.5 py-1 rounded-md text-xs font-medium">User</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-slate-400">{{ $user->created_at ? $user->created_at->format('M d, Y') : 'Unknown' }}</td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <a href="/users/{{ $user->id }}" class="text-slate-400 hover:text-white transition inline-block" title="View Profile"><i data-lucide="eye" class="w-4 h-4 inline"></i></a>
                                        <form action="/admin/users/{{ $user->id }}" method="POST" class="inline-block" onsubmit="return confirm('Delete user {{ $user->name }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-400 hover:text-rose-300 transition" title="Delete User"><i data-lucide="ban" class="w-4 h-4 inline"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center">
                                        <div class="flex flex-col items-center justify-center text-slate-500">
                                            <i data-lucide="users" class="w-8 h-8 mb-2 opacity-50"></i>
                                            <p class="text-sm">No recent registrations found.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 11. Notifications / System Alerts -->
        <div class="space-y-8">
            <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-2xl p-6 shadow-lg">
                <h3 class="text-base font-semibold text-white mb-4 flex items-center gap-2">
                    <i data-lucide="bell" class="w-5 h-5 text-amber-400"></i> System Alerts
                </h3>
                <div class="space-y-3">
                    <div class="flex gap-3 items-start p-3 bg-amber-500/10 border border-amber-500/20 rounded-xl">
                        <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-400 shrink-0 mt-0.5"></i>
                        <div>
                            <h4 class="text-sm font-medium text-amber-300">High API Latency</h4>
                            <p class="text-xs text-amber-400/70 mt-0.5">OpenRouter API responses are delayed.</p>
                        </div>
                    </div>
                    <div class="flex gap-3 items-start p-3 bg-blue-500/10 border border-blue-500/20 rounded-xl">
                        <i data-lucide="info" class="w-5 h-5 text-blue-400 shrink-0 mt-0.5"></i>
                        <div>
                            <h4 class="text-sm font-medium text-blue-300">Update Available</h4>
                            <p class="text-xs text-blue-400/70 mt-0.5">Laravel Framework v10.x.x is available.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics & Leaderboards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- 7. Top Creators Leaderboard -->
        <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-slate-700/50 bg-slate-800/30">
                <h3 class="text-base font-semibold text-white flex items-center gap-2">
                    <i data-lucide="award" class="w-5 h-5 text-yellow-400"></i> Top Creators Leaderboard
                </h3>
            </div>
            <div class="p-2">
                @forelse($topCreators as $creator)
                    <div class="flex items-center justify-between p-3 hover:bg-slate-800/40 rounded-xl transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center font-bold text-xs text-slate-400 border border-slate-700">
                                #{{ $loop->iteration }}
                            </div>
                            <img src="{{ $creator->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($creator->name ?? 'User').'&background=random' }}" class="w-10 h-10 rounded-full border border-slate-600">
                            <div>
                                <p class="font-medium text-slate-200 text-sm">{{ $creator->name }}</p>
                                <p class="text-xs text-slate-500">{{ $creator->prompts_count }} Prompts</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 text-xs font-medium text-slate-400">
                            <span class="flex items-center gap-1"><i data-lucide="eye" class="w-3.5 h-3.5"></i> {{ number_format($creator->views_total ?? 0) }}</span>
                            <span class="flex items-center gap-1"><i data-lucide="heart" class="w-3.5 h-3.5 text-rose-400"></i> {{ number_format($creator->likes_total ?? 0) }}</span>
                        </div>
                    </div>
                @empty
                    <div class="p-8 flex flex-col items-center justify-center text-slate-500">
                        <i data-lucide="award" class="w-8 h-8 mb-3 opacity-50"></i>
                        <p class="text-sm font-medium">No creators found yet.</p>
                        <p class="text-xs mt-1 text-slate-600">Leaderboard will appear here once users start creating.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 5. Prompt Analytics -->
        <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-slate-700/50 bg-slate-800/30">
                <h3 class="text-base font-semibold text-white flex items-center gap-2">
                    <i data-lucide="flame" class="w-5 h-5 text-orange-400"></i> Most Viewed Prompts
                </h3>
            </div>
            <div class="p-2">
                @forelse($topViewedPrompts as $prompt)
                    <a href="/prompts/{{ $prompt->slug ?? $prompt->id }}" class="flex items-center justify-between p-4 hover:bg-slate-800/40 rounded-xl transition-colors group">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-400 border border-orange-500/20 group-hover:scale-110 transition-transform">
                                <i data-lucide="file-text" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="font-medium text-slate-200 text-sm">{{ \Illuminate\Support\Str::limit($prompt->title, 40) }}</p>
                                <p class="text-xs text-slate-500">By {{ optional($prompt->user)->name ?? 'Unknown' }}</p>
                            </div>
                        </div>
                        <span class="flex items-center gap-1.5 text-sm font-semibold text-slate-300 bg-slate-800 px-3 py-1 rounded-full">
                            <i data-lucide="eye" class="w-4 h-4 text-slate-400"></i> {{ number_format($prompt->views_count ?? 0) }}
                        </span>
                    </a>
                @empty
                    <div class="p-8 flex flex-col items-center justify-center text-slate-500">
                        <i data-lucide="flame" class="w-8 h-8 mb-3 opacity-50 text-orange-400/50"></i>
                        <p class="text-sm font-medium">No prompts available.</p>
                        <p class="text-xs mt-1 text-slate-600">Prompts with the most views will appear here.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Bottom Widgets: Moderation, System Health, Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- 9. Moderation Center -->
        <div class="lg:col-span-1 bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-2xl p-6 shadow-lg">
            <h3 class="text-base font-semibold text-white mb-5 flex items-center gap-2">
                <i data-lucide="shield-alert" class="w-5 h-5 text-rose-400"></i> Moderation
            </h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-slate-800/50 rounded-xl p-4 text-center border border-slate-700">
                    <div class="text-2xl font-bold text-rose-400 mb-1">{{ $moderation['pending_reports'] }}</div>
                    <div class="text-xs font-medium text-slate-400 uppercase tracking-wide">Pending</div>
                </div>
                <div class="bg-slate-800/50 rounded-xl p-4 text-center border border-slate-700">
                    <div class="text-2xl font-bold text-amber-400 mb-1">{{ $moderation['flagged_prompts'] }}</div>
                    <div class="text-xs font-medium text-slate-400 uppercase tracking-wide">Flagged</div>
                </div>
                <div class="bg-slate-800/50 rounded-xl p-4 text-center border border-slate-700">
                    <div class="text-2xl font-bold text-slate-300 mb-1">{{ $moderation['banned_users'] }}</div>
                    <div class="text-xs font-medium text-slate-400 uppercase tracking-wide">Banned</div>
                </div>
                <div class="bg-slate-800/50 rounded-xl p-4 text-center border border-slate-700">
                    <div class="text-2xl font-bold text-slate-500 mb-1">{{ $moderation['deleted_prompts'] }}</div>
                    <div class="text-xs font-medium text-slate-400 uppercase tracking-wide">Deleted</div>
                </div>
            </div>
            <button class="w-full mt-5 bg-slate-800 hover:bg-slate-700 text-white font-medium py-2.5 rounded-xl border border-slate-600 transition-colors text-sm flex items-center justify-center gap-2 group">
                Review Queue <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
            </button>
        </div>

        <!-- 8. System Health -->
        <div class="lg:col-span-1 bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-2xl p-6 shadow-lg">
            <h3 class="text-base font-semibold text-white mb-5 flex items-center gap-2">
                <i data-lucide="server" class="w-5 h-5 text-cyan-400"></i> System Health
            </h3>
            <div class="space-y-3">
                @foreach($systemHealth as $service => $status)
                    @php 
                        $isOk = $status === 'Operational' || $status === 'Connected' || $status === 'Healthy';
                        $statusClasses = $isOk 
                            ? ['text' => 'text-emerald-400', 'bg' => 'bg-emerald-400', 'shadow' => 'shadow-[0_0_8px_rgba(52,211,153,0.8)]'] 
                            : ($status === 'Degraded' 
                                ? ['text' => 'text-amber-400', 'bg' => 'bg-amber-400', 'shadow' => 'shadow-[0_0_8px_rgba(251,191,36,0.8)]'] 
                                : ['text' => 'text-rose-400', 'bg' => 'bg-rose-400', 'shadow' => 'shadow-[0_0_8px_rgba(251,113,133,0.8)]']);
                    @endphp
                    <div class="flex items-center justify-between p-3 bg-slate-800/40 rounded-xl border border-slate-700/50">
                        <span class="text-sm font-medium text-slate-300 capitalize">{{ $service }}</span>
                        <span class="flex items-center gap-2 text-xs font-semibold {{ $statusClasses['text'] }}">
                            <span class="w-2 h-2 rounded-full {{ $statusClasses['bg'] }} {{ $statusClasses['shadow'] }}"></span>
                            {{ $status }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 10. Quick Actions -->
        <div class="lg:col-span-2 bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-2xl p-6 shadow-lg">
            <h3 class="text-base font-semibold text-white mb-5 flex items-center gap-2">
                <i data-lucide="zap" class="w-5 h-5 text-yellow-400"></i> Quick Actions
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                
                <a href="/prompts/create" class="flex flex-col items-center justify-center p-5 bg-slate-800/40 rounded-2xl border border-slate-700 hover:bg-violet-500/10 hover:border-violet-500/50 transition-all text-slate-400 hover:text-white group">
                    <i data-lucide="plus-circle" class="w-7 h-7 mb-3 text-violet-400 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium text-sm">Create Prompt</span>
                </a>
                
                <a href="/admin/users" class="flex flex-col items-center justify-center p-5 bg-slate-800/40 rounded-2xl border border-slate-700 hover:bg-blue-500/10 hover:border-blue-500/50 transition-all text-slate-400 hover:text-white group">
                    <i data-lucide="users" class="w-7 h-7 mb-3 text-blue-400 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium text-sm">Manage Users</span>
                </a>
                
                <a href="/admin/prompts" class="flex flex-col items-center justify-center p-5 bg-slate-800/40 rounded-2xl border border-slate-700 hover:bg-fuchsia-500/10 hover:border-fuchsia-500/50 transition-all text-slate-400 hover:text-white group">
                    <i data-lucide="folder-kanban" class="w-7 h-7 mb-3 text-fuchsia-400 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium text-sm">Manage Prompts</span>
                </a>
                
                <a href="/analytics" class="flex flex-col items-center justify-center p-5 bg-slate-800/40 rounded-2xl border border-slate-700 hover:bg-emerald-500/10 hover:border-emerald-500/50 transition-all text-slate-400 hover:text-white group">
                    <i data-lucide="pie-chart" class="w-7 h-7 mb-3 text-emerald-400 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium text-sm">Full Analytics</span>
                </a>
                
                <a href="/ai-generator" class="flex flex-col items-center justify-center p-5 bg-slate-800/40 rounded-2xl border border-slate-700 hover:bg-indigo-500/10 hover:border-indigo-500/50 transition-all text-slate-400 hover:text-white group">
                    <i data-lucide="bot" class="w-7 h-7 mb-3 text-indigo-400 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium text-sm">AI Tools</span>
                </a>
                
                <a href="/settings" class="flex flex-col items-center justify-center p-5 bg-slate-800/40 rounded-2xl border border-slate-700 hover:bg-slate-500/20 hover:border-slate-500/50 transition-all text-slate-400 hover:text-white group">
                    <i data-lucide="settings" class="w-7 h-7 mb-3 text-slate-400 group-hover:rotate-90 transition-transform duration-300"></i>
                    <span class="font-medium text-sm">System Settings</span>
                </a>

            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Refresh lucide icons
    if(window.lucide) { window.lucide.createIcons({ icons: window.lucide.icons }); }
});
</script>
@endsection