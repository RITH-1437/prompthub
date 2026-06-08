@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-12 font-sans">

    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 to-slate-800 p-8 border border-slate-700/50 shadow-2xl flex flex-col items-center justify-center text-center gap-6">
        <div class="relative z-10 flex flex-col items-center gap-4">
            <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center shadow-lg shadow-purple-500/30">
                <i data-lucide="compass" class="w-10 h-10 text-white"></i>
            </div>
            <div>
                <h1 class="text-4xl font-extrabold text-white tracking-tight mb-2">
                    Explore Prompts
                </h1>
                <p class="text-slate-400 text-base max-w-2xl mx-auto">Discover the best and most popular AI prompts created by the community. Find inspiration for your next project.</p>
            </div>
        </div>
        
        <!-- Search Bar -->
        <form action="/explore" method="GET" class="relative z-10 w-full max-w-2xl mt-4">
            <div class="relative flex items-center">
                <i data-lucide="search" class="absolute left-4 w-5 h-5 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search prompts, categories, or keywords..." class="w-full bg-slate-950/80 border border-slate-700 rounded-2xl py-4 pl-12 pr-32 text-white placeholder-slate-500 focus:outline-none focus:border-purple-500 transition-colors shadow-inner">
                <button type="submit" class="absolute right-2 bg-purple-600 hover:bg-purple-500 text-white font-medium px-6 py-2 rounded-xl transition-colors shadow-lg shadow-purple-500/20">
                    Search
                </button>
            </div>
        </form>

        <!-- Decorative glows -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 rounded-full bg-purple-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-pink-500/10 blur-3xl"></div>
    </div>

    <!-- Filters / Navigation -->
    <div class="flex items-center justify-between gap-4 overflow-x-auto pb-2 scrollbar-hide">
        <div class="flex gap-2">
            <a href="/explore" class="px-5 py-2.5 rounded-xl text-sm font-medium transition-all {{ !request('sort') || request('sort') == 'latest' ? 'bg-slate-800 text-white border border-slate-600 shadow-lg' : 'bg-slate-900/50 text-slate-400 border border-slate-800 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="sparkles" class="w-4 h-4 inline-block mr-1"></i> Latest
            </a>
            <a href="/explore?sort=popular" class="px-5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request('sort') == 'popular' ? 'bg-slate-800 text-white border border-slate-600 shadow-lg' : 'bg-slate-900/50 text-slate-400 border border-slate-800 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="trending-up" class="w-4 h-4 inline-block mr-1"></i> Popular
            </a>
            <a href="/explore?sort=top-rated" class="px-5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request('sort') == 'top-rated' ? 'bg-slate-800 text-white border border-slate-600 shadow-lg' : 'bg-slate-900/50 text-slate-400 border border-slate-800 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="star" class="w-4 h-4 inline-block mr-1"></i> Top Rated
            </a>
        </div>
    </div>

    <!-- Prompts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($prompts ?? [] as $prompt)
            <div class="relative group bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-6 hover:bg-slate-800/60 hover:border-purple-500/50 hover:-translate-y-1 hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300 flex flex-col h-full">
                
                <!-- Author & Category -->
                <div class="flex items-center justify-between mb-4">
                    <a href="/users/{{ $prompt->user->id ?? '#' }}" class="flex items-center gap-3 group/user relative z-20">
                        <div class="w-8 h-8 rounded-full bg-slate-800 overflow-hidden flex items-center justify-center border border-slate-700">
                            @if($prompt->user && $prompt->user->avatar)
                                <img src="{{ $prompt->user->avatar }}" alt="{{ $prompt->user->name }}" class="w-full h-full object-cover">
                            @else
                                <i data-lucide="user" class="w-4 h-4 text-slate-400"></i>
                            @endif
                        </div>
                        <span class="text-sm font-medium text-slate-300 group-hover/user:text-white transition-colors">{{ $prompt->user->name ?? 'Unknown' }}</span>
                    </a>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-purple-500/10 text-purple-400 border border-purple-500/20">
                        {{ optional($prompt->category)->name ?? 'Uncategorized' }}
                    </span>
                </div>

                <!-- Title & Description (Link stretches over card) -->
                <a href="/prompts/{{ $prompt->id }}" class="flex-1 focus:outline-none relative z-10 block mb-6">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    <h2 class="text-xl font-bold text-white mb-2 group-hover:text-purple-400 transition-colors line-clamp-2">
                        {{ $prompt->title }}
                    </h2>
                    <p class="text-sm text-slate-400 line-clamp-3">
                        {{ $prompt->prompt_content ?? $prompt->description ?? 'No description available.' }}
                    </p>
                </a>

                <!-- Stats -->
                <div class="mt-auto pt-4 border-t border-slate-700/50 flex items-center justify-between text-xs text-slate-400 relative z-20">
                    <div class="flex items-center gap-4">
                        <span class="flex items-center gap-1.5 hover:text-cyan-400 transition-colors" title="Views">
                            <i data-lucide="eye" class="w-4 h-4"></i> {{ number_format($prompt->views_count ?? 0) }}
                        </span>
                        <span class="flex items-center gap-1.5 hover:text-emerald-400 transition-colors" title="Copies">
                            <i data-lucide="copy" class="w-4 h-4"></i> {{ number_format($prompt->copy_count ?? 0) }}
                        </span>
                    </div>
                    <div class="flex items-center gap-1.5 text-yellow-500" title="Rating">
                        <span>{{ number_format(method_exists($prompt, 'averageRating') ? $prompt->averageRating() : 0, 1) }}</span>
                        <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-500"></i>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-16 text-center flex flex-col items-center justify-center shadow-lg">
                <div class="w-24 h-24 bg-slate-800/50 rounded-full flex items-center justify-center mb-6 border border-slate-700/50">
                    <i data-lucide="search-x" class="w-12 h-12 text-slate-500"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-3">No Prompts Found</h3>
                <p class="text-slate-400 mb-8 max-w-md text-center">We couldn't find any prompts matching your criteria. Try using different keywords or clearing your filters.</p>
                <a href="/explore" class="bg-purple-600 hover:bg-purple-500 px-6 py-3 rounded-xl text-white font-semibold transition-colors flex items-center gap-2 shadow-lg shadow-purple-500/20">
                    <i data-lucide="refresh-cw" class="w-5 h-5"></i> Clear Filters
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection