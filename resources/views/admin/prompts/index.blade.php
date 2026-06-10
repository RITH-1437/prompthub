@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-12 font-sans">

    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 to-slate-800 p-8 border border-slate-700/50 shadow-2xl flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
<img src="{{ asset('images/logo.png') }}" alt="PromptHub Logo" class="w-16 h-16 rounded-2xl shadow-lg shadow-purple-500/30">
                <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight mb-1">
                    Manage Prompts
                </h1>
                <p class="text-slate-400 text-sm">Review, feature, or remove prompts across the platform.</p>
            </div>
        </div>

        <!-- Decorative glows -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 rounded-full bg-purple-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-indigo-500/10 blur-3xl"></div>
    </div>

    <!-- Prompts List -->
    <div class="space-y-5">
        @forelse($prompts as $prompt)
            <div class="relative group bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-2xl p-6 hover:bg-slate-800/60 hover:border-purple-500/50 hover:-translate-y-1 hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300 flex flex-col md:flex-row md:items-center justify-between gap-6 overflow-hidden">
                
                <div class="flex-1 min-w-0 z-10">
                    <div class="flex items-center gap-3 mb-2">
                        <h2 class="text-xl font-bold text-white truncate">
                            <a href="/prompts/{{ $prompt->id }}" class="hover:text-purple-400 transition-colors focus:outline-none" target="_blank">
                                {{ $prompt->title }}
                            </a>
                        </h2>
                        @if($prompt->is_featured)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 uppercase tracking-wider">
                                <i data-lucide="star" class="w-3 h-3 mr-1 fill-yellow-400"></i> Featured
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-500/10 text-slate-400 border border-slate-500/20 uppercase tracking-wider">
                                Standard
                            </span>
                        @endif
                    </div>

                    <div class="text-slate-400 text-sm mb-4 flex items-center gap-2">
                        Creator: 
                        <a href="/users/{{ $prompt->user->id ?? '#' }}" class="flex items-center gap-1.5 text-slate-300 hover:text-white transition-colors font-medium">
                            <div class="w-5 h-5 rounded-full bg-slate-800 overflow-hidden flex items-center justify-center border border-slate-700 shrink-0">
                                @if(optional($prompt->user)->avatar)
                                    <img src="{{ $prompt->user->avatar }}" alt="{{ $prompt->user->name }}" class="w-full h-full object-cover">
                                @else
                                    <i data-lucide="user" class="w-3 h-3 text-slate-500"></i>
                                @endif
                            </div>
                            {{ optional($prompt->user)->name ?? 'Unknown' }}
                        </a>
                    </div>

                    <div class="flex flex-wrap items-center gap-x-6 gap-y-3 text-sm text-slate-400">
                        <span class="flex items-center gap-2 bg-slate-800/50 px-2.5 py-1 rounded-lg border border-slate-700/50" title="Views">
                            <i data-lucide="eye" class="w-4 h-4 text-cyan-400"></i> 
                            <span class="font-medium">{{ number_format($prompt->views_count ?? 0) }}</span>
                        </span>

                        <span class="flex items-center gap-2 bg-slate-800/50 px-2.5 py-1 rounded-lg border border-slate-700/50" title="Copies">
                            <i data-lucide="copy" class="w-4 h-4 text-emerald-400"></i> 
                            <span class="font-medium">{{ number_format($prompt->copy_count ?? 0) }}</span>
                        </span>

                        <span class="flex items-center gap-2 bg-slate-800/50 px-2.5 py-1 rounded-lg border border-slate-700/50" title="Favorites">
                            <i data-lucide="heart" class="w-4 h-4 text-rose-400"></i> 
                            <span class="font-medium">{{ number_format($prompt->favorites_count ?? 0) }}</span>
                        </span>

                        <span class="flex items-center gap-2 bg-slate-800/50 px-2.5 py-1 rounded-lg border border-slate-700/50" title="Comments">
                            <i data-lucide="message-circle" class="w-4 h-4 text-blue-400"></i> 
                            <span class="font-medium">{{ number_format($prompt->comments_count ?? 0) }}</span>
                        </span>
                        
                        <span class="flex items-center gap-2 text-xs text-slate-500 ml-auto md:ml-0">
                            <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                            {{ $prompt->created_at->format('M d, Y') }}
                        </span>
                    </div>
                </div>

                <div class="relative z-10 flex md:flex-col gap-3 shrink-0">
                    <form action="/admin/prompts/{{ $prompt->id }}/feature" method="POST" class="m-0 flex-1 md:flex-none flex">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full flex items-center justify-center gap-2 {{ $prompt->is_featured ? 'bg-slate-800 hover:bg-slate-700 text-slate-300 border-slate-600' : 'bg-yellow-500/10 hover:bg-yellow-500 text-yellow-500 hover:text-white border-yellow-500/30' }} px-4 py-2.5 rounded-xl border font-medium text-sm transition-all">
                            <i data-lucide="star" class="w-4 h-4 {{ $prompt->is_featured ? '' : 'fill-yellow-500' }}"></i> 
                            {{ $prompt->is_featured ? 'Unfeature' : 'Feature' }}
                        </button>
                    </form>

                    <form action="/admin/prompts/{{ $prompt->id }}" method="POST" class="m-0 flex-1 md:flex-none flex">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to permanently delete this prompt?')"
                            class="w-full flex items-center justify-center gap-2 bg-rose-500/10 hover:bg-rose-500 border border-rose-500/20 hover:border-rose-500 text-rose-400 hover:text-white px-4 py-2.5 rounded-xl font-medium text-sm transition-all group/btn">
                            <i data-lucide="trash-2" class="w-4 h-4 group-hover/btn:animate-bounce"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-16 text-center flex flex-col items-center justify-center shadow-lg">
                <div class="w-24 h-24 bg-slate-800/50 rounded-full flex items-center justify-center mb-6 border border-slate-700/50">
                    <i data-lucide="file-question" class="w-12 h-12 text-slate-500"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-3">No Prompts Found</h3>
                <p class="text-slate-400 mb-0 max-w-md text-center">There are no prompts available on the platform yet.</p>
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
