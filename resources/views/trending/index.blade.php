@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-12 font-sans">

    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 to-slate-800 p-8 border border-slate-700/50 shadow-2xl flex flex-col items-center justify-center text-center gap-6">
        <div class="relative z-10 flex flex-col items-center gap-4">
<img src="{{ asset('images/logo.png') }}" alt="PromptHub Logo" class="w-20 h-20 rounded-3xl shadow-lg shadow-orange-500/30">
                <div>
                <h1 class="text-4xl font-extrabold text-white tracking-tight mb-2">
                    Trending Prompts
                </h1>
                <p class="text-slate-400 text-base max-w-2xl mx-auto">Discover the most viewed and talked-about AI prompts right now. See what the community is currently building.</p>
            </div>
        </div>

        <!-- Decorative glows -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 rounded-full bg-orange-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-rose-500/10 blur-3xl"></div>
    </div>

    <!-- Prompts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($prompts ?? [] as $prompt)
            <div class="relative group bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-6 hover:bg-slate-800/60 hover:border-orange-500/50 hover:-translate-y-1 hover:shadow-xl hover:shadow-orange-500/10 transition-all duration-300 flex flex-col h-full">
                
                @if($prompt->is_featured)
                <!-- Featured Badge -->
                <div class="absolute -top-3 -right-3 z-30">
                    <span class="flex items-center justify-center w-8 h-8 bg-orange-500 text-white rounded-full shadow-lg shadow-orange-500/30" title="Featured Prompt">
                        <i data-lucide="star" class="w-4 h-4 fill-white"></i>
                    </span>
                </div>
                @endif

                <!-- Category & Trending Badge -->
                <div class="flex items-center justify-between mb-4 relative z-20">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-orange-500/10 text-orange-400 border border-orange-500/20">
                        {{ optional($prompt->category)->name ?? 'Uncategorized' }}
                    </span>
                    <div class="flex items-center gap-1.5 text-xs font-bold text-slate-400 bg-slate-800/50 px-2 py-1 rounded-md border border-slate-700">
                        <i data-lucide="trending-up" class="w-3.5 h-3.5 text-orange-400"></i> Trending
                    </div>
                </div>

                <!-- Title & Description (Link stretches over card) -->
                <a href="/prompts/{{ $prompt->id }}" class="flex-1 focus:outline-none relative z-10 block mb-4">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    <h2 class="text-xl font-bold text-white mb-2 group-hover:text-orange-400 transition-colors line-clamp-2">
                        {{ $prompt->title }}
                    </h2>
                    <p class="text-sm text-slate-400 line-clamp-3">
                        {{ $prompt->prompt_content ?? $prompt->description ?? 'No description available.' }}
                    </p>
                </a>

                @if($prompt->tags && $prompt->tags->count())
                    <div class="flex flex-wrap gap-2 mb-4 relative z-20">
                        @foreach($prompt->tags->take(3) as $tag)
                            <span class="px-2 py-0.5 bg-slate-800/50 border border-slate-700/50 rounded-md text-[10px] text-slate-400 uppercase tracking-wider hover:bg-slate-700 hover:text-white transition-colors cursor-pointer">
                                #{{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @endif

                <!-- User & Stats -->
                <div class="mt-auto pt-4 border-t border-slate-700/50 flex flex-wrap gap-4 items-center justify-between text-xs text-slate-400 relative z-20">
                    <a href="/users/{{ $prompt->user->id ?? '#' }}" class="flex items-center gap-2 group/user hover:text-white transition-colors">
                        <div class="w-6 h-6 rounded-full bg-slate-800 overflow-hidden flex items-center justify-center border border-slate-700">
                            @if($prompt->user && $prompt->user->avatar)
                                <img src="{{ $prompt->user->avatar }}" alt="{{ $prompt->user->name }}" class="w-full h-full object-cover">
                            @else
                                <i data-lucide="user" class="w-3 h-3 text-slate-400"></i>
                            @endif
                        </div>
                        <span class="font-medium">{{ $prompt->user->name ?? 'Unknown' }}</span>
                    </a>
                    
                    <div class="flex items-center gap-3">
                        <span class="flex items-center gap-1 hover:text-orange-400 transition-colors" title="Views">
                            <i data-lucide="eye" class="w-3.5 h-3.5"></i> {{ number_format($prompt->views_count ?? 0) }}
                        </span>
                        <div class="flex items-center gap-1 text-yellow-500" title="Average Rating">
                            <span>{{ number_format(method_exists($prompt, 'averageRating') ? $prompt->averageRating() : ($prompt->rating ?? 0), 1) }}</span>
                            <i data-lucide="star" class="w-3 h-3 fill-yellow-500"></i>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-16 text-center flex flex-col items-center justify-center shadow-lg">
                <div class="w-24 h-24 bg-slate-800/50 rounded-full flex items-center justify-center mb-6 border border-slate-700/50">
                    <i data-lucide="flame" class="w-12 h-12 text-slate-500"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-3">No Trending Prompts</h3>
                <p class="text-slate-400 mb-8 max-w-md text-center">It seems there are no trending prompts available right now. Check back later!</p>
                <a href="/explore" class="bg-orange-600 hover:bg-orange-500 px-6 py-3 rounded-xl text-white font-semibold transition-colors flex items-center gap-2 shadow-lg shadow-orange-500/20">
                    <i data-lucide="compass" class="w-5 h-5"></i> Explore Prompts
                </a>
            </div>
        @endforelse
    </div>
    
    @if(isset($prompts) && $prompts instanceof \Illuminate\Pagination\LengthAwarePaginator && $prompts->hasPages())
        <div class="mt-8">
            {{ $prompts->links() }}
        </div>
    @endif
</div>
@endsection