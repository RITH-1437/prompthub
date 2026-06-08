@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-12 font-sans">

    <!-- 1. Dashboard Overview / Hero Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 to-slate-800 p-8 border border-slate-700/50 shadow-2xl">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                    <i data-lucide="layout-dashboard" class="w-8 h-8 text-white"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-white tracking-tight mb-1">
                        Welcome back, {{ auth()->user()->name }}
                    </h1>
                    <p class="text-slate-400 text-sm">Here's your personal dashboard at a glance.</p>
                </div>
            </div>
            <a href="/prompts/create" class="bg-white text-slate-900 font-semibold px-6 py-3 rounded-xl hover:bg-slate-200 transition-colors flex items-center gap-2">
                <i data-lucide="plus" class="w-5 h-5"></i> Create New Prompt
            </a>
        </div>
        
        <!-- Decorative glows -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 rounded-full bg-blue-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-cyan-500/10 blur-3xl"></div>
    </div>

    <!-- 2. Statistics Cards -->
    @php
        $cards = [
            ['title' => 'My Prompts', 'value' => $totalPrompts, 'icon' => 'file-text', 'color' => 'blue'],
            ['title' => 'My Favorites', 'value' => $totalFavorites, 'icon' => 'heart', 'color' => 'rose'],
            ['title' => 'My Followers', 'value' => $totalFollowers, 'icon' => 'users', 'color' => 'emerald'],
            ['title' => 'AI Chats', 'value' => $totalChats, 'icon' => 'bot', 'color' => 'violet'],
        ];
        $colorClasses = [
            'blue' => ['bg' => 'bg-blue-500/10', 'hover_bg' => 'group-hover:bg-blue-500/20', 'border' => 'border-blue-500/20', 'text' => 'text-blue-400', 'shadow' => 'hover:shadow-blue-500/10'],
            'rose' => ['bg' => 'bg-rose-500/10', 'hover_bg' => 'group-hover:bg-rose-500/20', 'border' => 'border-rose-500/20', 'text' => 'text-rose-400', 'shadow' => 'hover:shadow-rose-500/10'],
            'emerald' => ['bg' => 'bg-emerald-500/10', 'hover_bg' => 'group-hover:bg-emerald-500/20', 'border' => 'border-emerald-500/20', 'text' => 'text-emerald-400', 'shadow' => 'hover:shadow-emerald-500/10'],
            'violet' => ['bg' => 'bg-violet-500/10', 'hover_bg' => 'group-hover:bg-violet-500/20', 'border' => 'border-violet-500/20', 'text' => 'text-violet-400', 'shadow' => 'hover:shadow-violet-500/10'],
        ];
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach($cards as $card)
            @php $colors = $colorClasses[$card['color']]; @endphp
            <div class="group relative bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-2xl p-6 hover:bg-slate-800/60 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl {{ $colors['shadow'] }} overflow-hidden cursor-default">
                <!-- Background gradient flare -->
                <div class="absolute -top-10 -right-10 w-32 h-32 {{ $colors['bg'] }} rounded-full blur-2xl {{ $colors['hover_bg'] }} transition-colors"></div>
                
                <div class="relative z-10">
                    <div class="p-3 inline-block {{ $colors['bg'] }} rounded-xl border {{ $colors['border'] }} {{ $colors['text'] }} mb-4">
                        <i data-lucide="{{ $card['icon'] }}" class="w-6 h-6"></i>
                    </div>
                    <p class="text-slate-400 text-sm font-medium mb-1">{{ $card['title'] }}</p>
                    <h3 class="text-4xl font-bold text-white tracking-tight">{{ number_format($card['value']) }}</h3>
                </div>
            </div>
        @endforeach
    </div>

    <!-- 3. Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Recent Prompts -->
        <div class="lg:col-span-2 bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-slate-700/50 bg-slate-800/30 flex justify-between items-center">
                <h3 class="text-base font-semibold text-white flex items-center gap-2">
                    <i data-lucide="clock" class="w-5 h-5 text-cyan-400"></i> My Recent Prompts
                </h3>
                <a href="/prompts" class="text-sm font-medium text-cyan-400 hover:text-cyan-300 transition-colors">View All</a>
            </div>
            <div class="p-2">
                @forelse($recentPrompts as $prompt)
                    <a href="/prompts/{{ $prompt->slug ?? $prompt->id }}" class="flex items-center justify-between p-4 hover:bg-slate-800/40 rounded-xl transition-colors group">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-slate-400 border border-slate-700 group-hover:scale-110 transition-transform">
                                <i data-lucide="file-text" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="font-medium text-slate-200 text-sm">{{ Str::limit($prompt->title, 40) }}</p>
                                <p class="text-xs text-slate-500">Created {{ $prompt->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <span class="flex items-center gap-1.5 text-sm font-semibold text-slate-300">
                            <i data-lucide="arrow-right" class="w-4 h-4 text-slate-500 group-hover:translate-x-1 transition-transform"></i>
                        </span>
                    </a>
                @empty
                    <div class="p-8 flex flex-col items-center justify-center text-slate-500">
                        <i data-lucide="file-text" class="w-8 h-8 mb-3 opacity-50"></i>
                        <p class="text-sm font-medium">You haven't created any prompts yet.</p>
                        <p class="text-xs mt-1 text-slate-600">Click "Create New Prompt" to get started.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-2xl p-6 shadow-lg">
            <h3 class="text-base font-semibold text-white mb-5 flex items-center gap-2">
                <i data-lucide="zap" class="w-5 h-5 text-yellow-400"></i> Quick Actions
            </h3>
            <div class="grid grid-cols-2 gap-4">
                
                <a href="/prompts/create" class="flex flex-col items-center justify-center p-5 bg-slate-800/40 rounded-2xl border border-slate-700 hover:bg-violet-500/10 hover:border-violet-500/50 transition-all text-slate-400 hover:text-white group">
                    <i data-lucide="plus-circle" class="w-7 h-7 mb-3 text-violet-400 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium text-sm text-center">Create Prompt</span>
                </a>
                
                <a href="/ai-generator" class="flex flex-col items-center justify-center p-5 bg-slate-800/40 rounded-2xl border border-slate-700 hover:bg-indigo-500/10 hover:border-indigo-500/50 transition-all text-slate-400 hover:text-white group">
                    <i data-lucide="bot" class="w-7 h-7 mb-3 text-indigo-400 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium text-sm text-center">AI Generator</span>
                </a>
                
                <a href="/profile" class="flex flex-col items-center justify-center p-5 bg-slate-800/40 rounded-2xl border border-slate-700 hover:bg-blue-500/10 hover:border-blue-500/50 transition-all text-slate-400 hover:text-white group">
                    <i data-lucide="user" class="w-7 h-7 mb-3 text-blue-400 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium text-sm text-center">My Profile</span>
                </a>
                
                <a href="/explore" class="flex flex-col items-center justify-center p-5 bg-slate-800/40 rounded-2xl border border-slate-700 hover:bg-emerald-500/10 hover:border-emerald-500/50 transition-all text-slate-400 hover:text-white group">
                    <i data-lucide="compass" class="w-7 h-7 mb-3 text-emerald-400 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium text-sm text-center">Explore</span>
                </a>

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if(window.lucide) {
        lucide.createIcons();
    }
});
</script>
@endpush
@endsection