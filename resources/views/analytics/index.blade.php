@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-12 font-sans">

    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 to-slate-800 p-8 border border-slate-700/50 shadow-2xl flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
<img src="{{ asset('images/logo.png') }}" alt="PromptHub Logo" class="w-16 h-16 rounded-2xl shadow-lg shadow-blue-500/30">
                <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight mb-1">
                    Analytics Overview
                </h1>
                <p class="text-slate-400 text-sm">Track your prompt performance and engagement metrics.</p>
            </div>
        </div>
        
        <!-- Time Filter Controls -->
        <div class="relative z-10 flex items-center gap-2 bg-slate-800/50 p-1.5 rounded-xl border border-slate-700/50 backdrop-blur-md">
            @php
                $period = $period ?? 'all';
                $baseClasses = 'px-4 py-2 text-sm font-medium rounded-lg transition-colors';
                $activeClasses = 'text-white bg-slate-700 shadow';
                $inactiveClasses = 'text-slate-400 hover:text-white';
            @endphp
            <a href="{{ url('/analytics') }}" class="{{ $baseClasses }} {{ $period == 'all' ? $activeClasses : $inactiveClasses }}">All Time</a>
            <a href="{{ url('/analytics?period=30') }}" class="{{ $baseClasses }} {{ $period == '30' ? $activeClasses : $inactiveClasses }}">30 Days</a>
            <a href="{{ url('/analytics?period=7') }}" class="{{ $baseClasses }} {{ $period == '7' ? $activeClasses : $inactiveClasses }}">7 Days</a>
        </div>

        <!-- Decorative glows -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 rounded-full bg-blue-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-indigo-500/10 blur-3xl"></div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Views -->
        <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-6 relative overflow-hidden group hover:border-cyan-500/50 transition-colors">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-cyan-500/10 rounded-full blur-2xl group-hover:bg-cyan-500/20 transition-colors"></div>
            <div class="flex items-start justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-cyan-500/10 flex items-center justify-center border border-cyan-500/20 text-cyan-400 group-hover:scale-110 transition-transform">
                    <i data-lucide="eye" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="relative z-10">
                <h3 class="text-slate-400 text-sm font-medium mb-1">Total Views</h3>
                <div class="text-3xl font-bold text-white">{{ number_format($totalViews ?? 0) }}</div>
            </div>
        </div>

        <!-- Copies -->
        <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-6 relative overflow-hidden group hover:border-emerald-500/50 transition-colors">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition-colors"></div>
            <div class="flex items-start justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center border border-emerald-500/20 text-emerald-400 group-hover:scale-110 transition-transform">
                    <i data-lucide="copy" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="relative z-10">
                <h3 class="text-slate-400 text-sm font-medium mb-1">Total Copies</h3>
                <div class="text-3xl font-bold text-white">{{ number_format($totalCopies ?? 0) }}</div>
            </div>
        </div>

        <!-- Favorites -->
        <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-6 relative overflow-hidden group hover:border-rose-500/50 transition-colors">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-rose-500/10 rounded-full blur-2xl group-hover:bg-rose-500/20 transition-colors"></div>
            <div class="flex items-start justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-rose-500/10 flex items-center justify-center border border-rose-500/20 text-rose-400 group-hover:scale-110 transition-transform">
                    <i data-lucide="heart" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="relative z-10">
                <h3 class="text-slate-400 text-sm font-medium mb-1">Total Favorites</h3>
                <div class="text-3xl font-bold text-white">{{ number_format($totalFavorites ?? 0) }}</div>
            </div>
        </div>

        <!-- Prompts -->
        <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-6 relative overflow-hidden group hover:border-violet-500/50 transition-colors">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-violet-500/10 rounded-full blur-2xl group-hover:bg-violet-500/20 transition-colors"></div>
            <div class="flex items-start justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-violet-500/10 flex items-center justify-center border border-violet-500/20 text-violet-400 group-hover:scale-110 transition-transform">
                    <i data-lucide="layers" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="relative z-10">
                <h3 class="text-slate-400 text-sm font-medium mb-1">Active Prompts</h3>
                <div class="text-3xl font-bold text-white">{{ number_format($totalPrompts ?? 0) }}</div>
            </div>
        </div>
    </div>

    <!-- Bottom Analytics Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Top Performing Prompts (Takes up 2 columns on large screens) -->
        <div class="lg:col-span-2 bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-8 overflow-hidden">
            <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                <i data-lucide="trending-up" class="w-5 h-5 text-emerald-400"></i> Top Performing Prompts
            </h2>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-700/50 text-sm text-slate-400">
                            <th class="pb-3 font-medium px-2">Prompt Title</th>
                            <th class="pb-3 font-medium text-right px-2">Views</th>
                            <th class="pb-3 font-medium text-right px-2">Copies</th>
                            <th class="pb-3 font-medium text-right px-2">Rating</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-800/50">
                        @forelse($topPrompts ?? [] as $prompt)
                        <tr class="group hover:bg-slate-800/30 transition-colors">
                            <td class="py-4 px-2">
                                <a href="/prompts/{{ $prompt->id }}" class="font-semibold text-slate-200 group-hover:text-blue-400 transition-colors flex items-center gap-2">
                                    {{ Str::limit($prompt->title, 40) }}
                                </a>
                            </td>
                            <td class="py-4 text-right text-slate-300 px-2">{{ number_format($prompt->views_count ?? 0) }}</td>
                            <td class="py-4 text-right text-slate-300 px-2">{{ number_format($prompt->copy_count ?? 0) }}</td>
                            <td class="py-4 text-right text-slate-300 px-2">
                                <span class="flex items-center justify-end gap-1 text-yellow-400">
                                    {{ number_format($prompt->ratings_avg_rating ?? 0, 1) }} <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400"></i>
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-500">
                                <i data-lucide="inbox" class="w-10 h-10 mx-auto mb-3 opacity-50"></i>
                                <p>No prompt analytics available yet.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Engagement Breakdown (1 column) -->
        <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-8 flex flex-col">
            <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                <i data-lucide="pie-chart" class="w-5 h-5 text-indigo-400"></i> Interaction Breakdown
            </h2>
            
            <div class="flex-1 flex flex-col items-center justify-center">
                <!-- Custom CSS Donut Chart Placeholder (A visual representation before adding a JS library) -->
                <div class="relative w-48 h-48 mb-8 mt-4">
                    <svg viewBox="0 0 100 100" class="w-full h-full transform -rotate-90">
                        <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="15" fill="transparent" class="text-slate-800"></circle>
                        <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="15" fill="transparent" stroke-dasharray="251.2" stroke-dashoffset="60" class="text-cyan-500"></circle>
                        <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="15" fill="transparent" stroke-dasharray="251.2" stroke-dashoffset="190" class="text-emerald-500"></circle>
                        <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="15" fill="transparent" stroke-dasharray="251.2" stroke-dashoffset="230" class="text-rose-500"></circle>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center flex-col">
                        <span class="text-2xl font-bold text-white">{{ number_format(($totalViews ?? 0) + ($totalCopies ?? 0) + ($totalFavorites ?? 0)) }}</span>
                        <span class="text-xs text-slate-400">Total Interactions</span>
                    </div>
                </div>
                
                <div class="w-full space-y-4">
                    <div class="flex items-center justify-between text-sm bg-slate-800/30 p-3 rounded-xl border border-slate-700/30">
                        <div class="flex items-center gap-3 text-slate-300">
                            <div class="w-3 h-3 rounded-full bg-cyan-500 shadow-[0_0_8px_rgba(6,182,212,0.6)]"></div> Views
                        </div>
                        <span class="font-medium text-white">{{ number_format($totalViews ?? 0) }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm bg-slate-800/30 p-3 rounded-xl border border-slate-700/30">
                        <div class="flex items-center gap-3 text-slate-300">
                            <div class="w-3 h-3 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.6)]"></div> Copies
                        </div>
                        <span class="font-medium text-white">{{ number_format($totalCopies ?? 0) }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm bg-slate-800/30 p-3 rounded-xl border border-slate-700/30">
                        <div class="flex items-center gap-3 text-slate-300">
                            <div class="w-3 h-3 rounded-full bg-rose-500 shadow-[0_0_8px_rgba(244,63,94,0.6)]"></div> Favorites
                        </div>
                        <span class="font-medium text-white">{{ number_format($totalFavorites ?? 0) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection