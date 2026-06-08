@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-12 font-sans">

    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 to-slate-800 p-8 border border-slate-700/50 shadow-2xl flex flex-col md:flex-row justify-between items-center gap-6 text-center md:text-left">
        <div class="flex flex-col md:flex-row items-center gap-5 relative z-10">
            <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center shadow-lg shadow-amber-500/30 shrink-0">
                <i data-lucide="award" class="w-10 h-10 text-white"></i>
            </div>
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight mb-2">
                    Top Rated Prompts
                </h1>
                <p class="text-slate-400 text-sm md:text-base max-w-2xl">
                    Discover the highest-quality AI prompts, hand-picked and highly rated by the community.
                </p>
            </div>
        </div>

        <!-- Decorative glows -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 rounded-full bg-amber-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-orange-500/10 blur-3xl"></div>
    </div>

    <!-- Prompts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($prompts ?? [] as $prompt)
            <div class="relative group bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-6 hover:bg-slate-800/60 hover:border-amber-500/50 hover:-translate-y-1 hover:shadow-xl hover:shadow-amber-500/10 transition-all duration-300 flex flex-col h-full">
                
                <!-- Ranking Badge & Category -->
                <div class="flex items-center justify-between mb-4 relative z-20">
                    <div class="flex items-center gap-2">
                        <span class="flex items-center justify-center px-3 py-1 rounded-full bg-amber-500 text-white font-bold text-sm shadow-md shadow-amber-500/20">
                            #{{ $loop->iteration + (($prompts instanceof \Illuminate\Pagination\LengthAwarePaginator) ? ($prompts->currentPage() - 1) * $prompts->perPage() : 0) }}
                        </span>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-amber-500/10 text-amber-400 border border-amber-500/20">
                        {{ optional($prompt->category)->name ?? 'Uncategorized' }}
                    </span>
                </div>

                <!-- Title & Description (Link stretches over card) -->
                <a href="/prompts/{{ $prompt->id }}" class="flex-1 focus:outline-none relative z-10 block mb-6">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    <h2 class="text-xl font-bold text-white mb-2 group-hover:text-amber-400 transition-colors line-clamp-2">
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
                    
                    <div class="flex items-center gap-1.5 font-bold text-amber-400 bg-amber-500/10 px-2 py-1 rounded-md border border-amber-500/20" title="Average Rating">
                        <span>{{ number_format(method_exists($prompt, 'averageRating') ? $prompt->averageRating() : ($prompt->rating ?? 0), 1) }}</span>
                        <i data-lucide="star" class="w-3.5 h-3.5 fill-amber-400"></i>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-16 text-center flex flex-col items-center justify-center shadow-lg">
                <div class="w-24 h-24 bg-slate-800/50 rounded-full flex items-center justify-center mb-6 border border-slate-700/50">
                    <i data-lucide="star-off" class="w-12 h-12 text-slate-500"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-3">No Top Rated Prompts</h3>
                <p class="text-slate-400 mb-8 max-w-md text-center">It seems there are no top rated prompts available at the moment. Check back later!</p>
                <a href="/explore" class="bg-amber-600 hover:bg-amber-500 px-6 py-3 rounded-xl text-white font-semibold transition-colors flex items-center gap-2 shadow-lg shadow-amber-500/20">
                    <i data-lucide="compass" class="w-5 h-5"></i> Explore Prompts
                </a>
            </div>
        @endforelse
    </div>
    
    @if(isset($prompts) && $prompts instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-8">
            {{ $prompts->links() }}
        </div>
    @endif
</div>
@endsection