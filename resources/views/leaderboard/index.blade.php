@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-12 font-sans">

    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 to-slate-800 p-8 border border-slate-700/50 shadow-2xl flex flex-col items-center justify-center text-center gap-6">
        <div class="relative z-10 flex flex-col items-center gap-4">
            <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-yellow-500 to-amber-600 flex items-center justify-center shadow-lg shadow-yellow-500/30">
                <i data-lucide="trophy" class="w-10 h-10 text-white"></i>
            </div>
            <div>
                <h1 class="text-4xl font-extrabold text-white tracking-tight mb-2">
                    Creator Leaderboard
                </h1>
                <p class="text-slate-400 text-base max-w-2xl mx-auto">Discover the top contributors making waves in the community. Rank is determined by the total number of prompt views and copies.</p>
            </div>
        </div>

        <!-- Decorative glows -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 rounded-full bg-yellow-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-amber-500/10 blur-3xl"></div>
    </div>

    <!-- Leaderboard List -->
    <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-max">
                <thead>
                    <tr class="border-b border-slate-700/50 bg-slate-800/30 text-xs uppercase tracking-wider text-slate-400">
                        <th class="py-4 px-6 font-semibold w-20 text-center">Rank</th>
                        <th class="py-4 px-6 font-semibold">Creator</th>
                        <th class="py-4 px-6 font-semibold text-right">Prompts</th>
                        <th class="py-4 px-6 font-semibold text-right">Views</th>
                        <th class="py-4 px-6 font-semibold text-right">Copies</th>
                        <th class="py-4 px-6 font-semibold text-right">Total Score</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/50 text-sm">
                    @forelse($users ?? [] as $user)
                        @php
                            $rank = $loop->iteration;
                            $isTop3 = $rank <= 3;
                            $rankColor = match($rank) {
                                1 => 'text-yellow-400 bg-yellow-500/10 border-yellow-500/20',
                                2 => 'text-slate-300 bg-slate-400/10 border-slate-400/20',
                                3 => 'text-amber-600 bg-amber-700/10 border-amber-700/20',
                                default => 'text-slate-500 bg-slate-800/50 border-slate-700/50'
                            };
                            $rowHover = match($rank) {
                                1 => 'hover:bg-yellow-500/5',
                                2 => 'hover:bg-slate-400/5',
                                3 => 'hover:bg-amber-700/5',
                                default => 'hover:bg-slate-800/30'
                            };
                        @endphp
                        <tr class="transition-colors group {{ $rowHover }}">
                            <td class="py-4 px-6">
                                <div class="flex items-center justify-center w-8 h-8 mx-auto rounded-xl font-bold border {{ $rankColor }} shadow-sm">
                                    {{ $rank }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <a href="{{ route('users.show', $user) }}" class="flex items-center gap-3 group/user w-fit">
                                    <div class="w-10 h-10 rounded-full bg-slate-800 overflow-hidden flex items-center justify-center border {{ $isTop3 ? str_replace('bg-', 'border-', $rankColor) : 'border-slate-700' }}">
                                        @if($user->avatar)
                                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                        @else
                                            <i data-lucide="user" class="w-5 h-5 {{ $isTop3 ? 'text-current' : 'text-slate-400' }}"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-200 group-hover/user:text-white transition-colors flex items-center gap-2">
                                            {{ $user->name }}
                                            @if($rank === 1)
                                                <i data-lucide="crown" class="w-4 h-4 text-yellow-400"></i>
                                            @endif
                                        </div>
                                        <div class="text-xs text-slate-500">Joined {{ $user->created_at->format('M Y') }}</div>
                                    </div>
                                </a>
                            </td>
                            <td class="py-4 px-6 text-right text-slate-300">{{ number_format($user->prompts->count()) }}</td>
                            <td class="py-4 px-6 text-right text-slate-300">{{ number_format($user->views_total ?? 0) }}</td>
                            <td class="py-4 px-6 text-right text-slate-300">{{ number_format($user->copies_total ?? 0) }}</td>
                            <td class="py-4 px-6 text-right">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-sm font-bold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                    <i data-lucide="zap" class="w-4 h-4"></i> {{ number_format($user->score ?? 0) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center text-slate-500">
                                <i data-lucide="users" class="w-12 h-12 mx-auto mb-4 opacity-50"></i>
                                <p>No creators have been ranked yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection