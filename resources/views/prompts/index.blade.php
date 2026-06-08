@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-12 font-sans">

    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 to-slate-800 p-8 border border-slate-700/50 shadow-2xl flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                <i data-lucide="folder-open" class="w-8 h-8 text-white"></i>
            </div>
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight mb-1">
                    My Prompts
                </h1>
                <p class="text-slate-400 text-sm">Manage and organize your AI prompts.</p>
            </div>
        </div>
        <a href="/prompts/create" class="relative z-10 bg-white text-slate-900 font-semibold px-6 py-3 rounded-xl hover:bg-slate-200 transition-colors flex items-center gap-2 shadow-lg shadow-white/10 hover:shadow-white/20">
            <i data-lucide="plus" class="w-5 h-5"></i> Create New Prompt
        </a>
        
        <!-- Decorative glows -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 rounded-full bg-blue-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-cyan-500/10 blur-3xl"></div>
    </div>

    <!-- Prompts List -->
    <div class="space-y-5">
        @forelse($prompts as $prompt)
            <div class="relative group bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-2xl p-6 hover:bg-slate-800/60 hover:border-blue-500/50 hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 flex flex-col sm:flex-row sm:items-center justify-between gap-6 overflow-hidden">
                
                <!-- Card Background Glow (on hover) -->
                <div class="absolute -right-20 -top-20 w-40 h-40 bg-blue-500/0 group-hover:bg-blue-500/10 rounded-full blur-3xl transition-colors duration-500"></div>

                <div class="flex-1 min-w-0 z-10">
                    <h2 class="text-xl font-bold text-white mb-2 truncate">
                        <a href="/prompts/{{ $prompt->id }}" class="hover:text-blue-400 transition-colors focus:outline-none">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            {{ $prompt->title }}
                        </a>
                    </h2>

                    <div class="flex flex-wrap items-center gap-x-6 gap-y-3 text-sm text-slate-400">
                        <span class="flex items-center gap-2 bg-slate-800/50 px-2.5 py-1 rounded-lg border border-slate-700/50" title="Views">
                            <i data-lucide="eye" class="w-4 h-4 text-cyan-400"></i> 
                            <span class="font-medium">{{ number_format($prompt->views_count) }}</span>
                        </span>

                        <span class="flex items-center gap-2 bg-slate-800/50 px-2.5 py-1 rounded-lg border border-slate-700/50" title="Copies">
                            <i data-lucide="copy" class="w-4 h-4 text-emerald-400"></i> 
                            <span class="font-medium">{{ number_format($prompt->copy_count) }}</span>
                        </span>

                        <span class="flex items-center gap-2 bg-slate-800/50 px-2.5 py-1 rounded-lg border border-slate-700/50" title="Favorites">
                            <i data-lucide="heart" class="w-4 h-4 text-rose-400"></i> 
                            <span class="font-medium">{{ number_format($prompt->favorites_count) }}</span>
                        </span>

                        <span class="flex items-center gap-2 bg-slate-800/50 px-2.5 py-1 rounded-lg border border-slate-700/50" title="Comments">
                            <i data-lucide="message-circle" class="w-4 h-4 text-blue-400"></i> 
                            <span class="font-medium">{{ number_format($prompt->comments_count) }}</span>
                        </span>

                        <span class="flex items-center gap-2 text-xs text-slate-500 ml-auto sm:ml-0">
                            <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                            Created {{ $prompt->created_at->diffForHumans() }}
                        </span>
                    </div>

                    @php
                        $userRating = optional($prompt->ratings->first())->rating;
                    @endphp
                    <form
                        action="/prompts/{{ $prompt->id }}/rate"
                        method="POST"
                        class="relative z-10 mt-4 flex items-center gap-1 flex-row-reverse justify-end sm:justify-start [&>button:hover]:text-yellow-400 [&>button:focus-visible]:text-yellow-400 [&>button:hover~button]:text-yellow-400 [&>button:focus-visible~button]:text-yellow-400"
                    >
                        @csrf
                        @for ($i = 5; $i >= 1; $i--)
                            <button
                                type="submit"
                                name="rating"
                                value="{{ $i }}"
                                aria-label="Rate {{ $i }} stars"
                                class="{{ $userRating >= $i ? 'text-yellow-400' : 'text-slate-600' }} hover:scale-110 transition-all focus:outline-none"
                            >
                                <i data-lucide="star" class="w-4 h-4 {{ $userRating >= $i ? 'fill-yellow-400' : '' }}"></i>
                            </button>
                        @endfor
                        <span class="text-xs text-slate-500 mr-2">Your Rating:</span>
                    </form>

                </div>

                <div class="relative z-10 flex sm:flex-col gap-3">
                    <a href="/prompts/{{ $prompt->id }}/edit"
                        class="flex-1 sm:flex-none flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-white px-4 py-2.5 rounded-xl border border-slate-600 hover:border-slate-500 font-medium text-sm transition-all group/btn">
                        <i data-lucide="edit-3" class="w-4 h-4 text-slate-400 group-hover/btn:text-white transition-colors"></i> Edit
                    </a>

                    <form action="/prompts/{{ $prompt->id }}" method="POST" class="m-0 flex-1 sm:flex-none flex">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this prompt? This action cannot be undone.')"
                            class="w-full flex items-center justify-center gap-2 bg-rose-500/10 hover:bg-rose-500 border border-rose-500/20 hover:border-rose-500 text-rose-400 hover:text-white px-4 py-2.5 rounded-xl font-medium text-sm transition-all group/btn">
                            <i data-lucide="trash-2" class="w-4 h-4 group-hover/btn:animate-bounce"></i> Delete
                        </button>
                    </form>
                </div>

            </div>

        @empty
            <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-12 text-center flex flex-col items-center justify-center shadow-lg">
                <div class="w-20 h-20 bg-slate-800/50 rounded-full flex items-center justify-center mb-6 border border-slate-700/50">
                    <i data-lucide="file-question" class="w-10 h-10 text-slate-500"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">No Prompts Found</h3>
                <p class="text-slate-400 mb-8 max-w-md">You haven't created any prompts yet. Start building your collection of AI prompts today!</p>
                <a href="/prompts/create" class="bg-blue-500 hover:bg-blue-600 px-6 py-3 rounded-xl text-white font-semibold transition-colors flex items-center gap-2 shadow-lg shadow-blue-500/20">
                    <i data-lucide="plus" class="w-5 h-5"></i> Create Your First Prompt
                </a>
            </div>
        @endforelse
    </div>

</div>
@endsection