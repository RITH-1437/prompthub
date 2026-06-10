@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-12 font-sans">

    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 to-slate-800 p-8 border border-slate-700/50 shadow-2xl flex flex-col items-center md:items-start justify-center text-center md:text-left gap-6">
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-5">
<img src="{{ asset('images/logo.png') }}" alt="PromptHub Logo" class="w-20 h-20 rounded-3xl shadow-lg shadow-rose-500/30 shrink-0">
                <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight mb-2">
                    My Favorites
                </h1>
                <p class="text-slate-400 text-sm md:text-base max-w-2xl">
                    A collection of all the AI prompts you've liked and saved for quick access.
                </p>
            </div>
        </div>

        <!-- Decorative glows -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 rounded-full bg-rose-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-pink-500/10 blur-3xl"></div>
    </div>

    <!-- Prompts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($favorites ?? [] as $favorite)
            @php $prompt = $favorite->prompt; @endphp
            @if($prompt)
            <div class="relative group bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-6 hover:bg-slate-800/60 hover:border-rose-500/50 hover:-translate-y-1 hover:shadow-xl hover:shadow-rose-500/10 transition-all duration-300 flex flex-col h-full">
                
                <!-- Category & Unfavorite -->
                <div class="flex items-center justify-between mb-4 relative z-20">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-rose-500/10 text-rose-400 border border-rose-500/20">
                        {{ optional($prompt->category)->name ?? 'Uncategorized' }}
                    </span>
                    <form action="/favorites/{{ $prompt->id }}" method="POST" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-rose-400 hover:text-white bg-rose-500/10 hover:bg-rose-500 rounded-lg transition-colors border border-transparent hover:border-rose-500/30" title="Remove from favorites">
                            <i data-lucide="heart-off" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>

                <!-- Title & Description (Link stretches over card) -->
                <a href="/prompts/{{ $prompt->id }}" class="flex-1 focus:outline-none relative z-10 block mb-6">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    <h2 class="text-xl font-bold text-white mb-2 group-hover:text-rose-400 transition-colors line-clamp-2">
                        {{ $prompt->title }}
                    </h2>
                    <p class="text-sm text-slate-400 line-clamp-3">
                        {{ $prompt->prompt_content ?? $prompt->description ?? 'No description available.' }}
                    </p>
                </a>

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
                        <span class="flex items-center gap-1 hover:text-cyan-400 transition-colors" title="Views">
                            <i data-lucide="eye" class="w-3.5 h-3.5"></i> {{ number_format($prompt->views_count ?? 0) }}
                        </span>
                        <span class="flex items-center gap-1 hover:text-emerald-400 transition-colors" title="Copies">
                            <i data-lucide="copy" class="w-3.5 h-3.5"></i> {{ number_format($prompt->copy_count ?? 0) }}
                        </span>
                    </div>
                </div>
            </div>
            @endif
        @empty
            <div class="col-span-full bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-16 text-center flex flex-col items-center justify-center shadow-lg">
                <div class="w-24 h-24 bg-slate-800/50 rounded-full flex items-center justify-center mb-6 border border-slate-700/50">
                    <i data-lucide="heart" class="w-12 h-12 text-slate-500"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-3">No Favorites Yet</h3>
                <p class="text-slate-400 mb-8 max-w-md text-center">You haven't added any prompts to your favorites yet. Start exploring and save the ones you love!</p>
                <a href="/explore" class="bg-rose-600 hover:bg-rose-500 px-6 py-3 rounded-xl text-white font-semibold transition-colors flex items-center gap-2 shadow-lg shadow-rose-500/20">
                    <i data-lucide="compass" class="w-5 h-5"></i> Explore Prompts
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection