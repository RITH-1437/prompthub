@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-12 font-sans">

    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 to-slate-800 p-8 border border-slate-700/50 shadow-2xl flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30">
                <i data-lucide="folder-open" class="w-8 h-8 text-white"></i>
            </div>
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight mb-1">
                    {{ $collection->name }}
                </h1>
                <p class="text-slate-400 text-sm max-w-xl">
                    {{ $collection->description ?? 'No description provided for this collection.' }}
                </p>
                <div class="mt-2 flex items-center gap-2 text-xs text-slate-500">
                    <span class="flex items-center gap-1"><i data-lucide="file-text" class="w-3.5 h-3.5"></i> {{ $collection->prompts->count() }} Prompts</span>
                </div>
            </div>
        </div>
        
        <div class="relative z-10 flex gap-3 flex-wrap">
            <a href="{{ route('collections.index') }}" class="bg-slate-800 hover:bg-slate-700 text-white font-semibold px-5 py-2.5 rounded-xl border border-slate-600 transition-colors flex items-center gap-2 shadow-lg shadow-black/20">
                <i data-lucide="arrow-left" class="w-4 h-4 text-slate-400"></i> Back
            </a>
            @if(auth()->check() && $collection->user_id == auth()->id())
                <form action="{{ route('collections.destroy', $collection->id) }}" method="POST" class="m-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this collection?')" class="bg-rose-500/10 hover:bg-rose-500 border border-rose-500/20 hover:border-rose-500 text-rose-400 hover:text-white px-5 py-2.5 rounded-xl font-medium text-sm transition-all flex items-center gap-2">
                        <i data-lucide="trash-2" class="w-4 h-4"></i> Delete
                    </button>
                </form>
            @endif
        </div>
        
        <!-- Decorative glows -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 rounded-full bg-emerald-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-teal-500/10 blur-3xl"></div>
    </div>

    <div>
        <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
            <i data-lucide="layers" class="w-6 h-6 text-emerald-400"></i> Prompts in this Collection
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($collection->prompts as $prompt)
                <div class="relative group bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-6 hover:bg-slate-800/60 hover:border-emerald-500/50 hover:-translate-y-1 hover:shadow-xl hover:shadow-emerald-500/10 transition-all duration-300 flex flex-col h-full">
                    
                    <div class="flex items-center justify-between mb-4 relative z-20">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">
                            {{ optional($prompt->category)->name ?? 'Uncategorized' }}
                        </span>
                    </div>

                    <!-- Title & Description (Link stretches over card) -->
                    <a href="/prompts/{{ $prompt->id }}" class="flex-1 focus:outline-none relative z-10 block mb-6">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <h2 class="text-xl font-bold text-white mb-2 group-hover:text-emerald-400 transition-colors line-clamp-2">
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
                <div class="col-span-full bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-12 text-center flex flex-col items-center justify-center shadow-lg">
                    <div class="w-20 h-20 bg-slate-800/50 rounded-full flex items-center justify-center mb-6 border border-slate-700/50">
                        <i data-lucide="inbox" class="w-10 h-10 text-slate-500"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">No Prompts Yet</h3>
                    <p class="text-slate-400 mb-8 max-w-md">This collection doesn't have any prompts yet. You can add prompts from the prompt details page.</p>
                    <a href="/explore" class="bg-emerald-500 hover:bg-emerald-600 px-6 py-3 rounded-xl text-white font-semibold transition-colors flex items-center gap-2 shadow-lg shadow-emerald-500/20">
                        <i data-lucide="compass" class="w-5 h-5"></i> Explore Prompts
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection