@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 pb-12 font-sans">

    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 to-slate-800 p-8 border border-slate-700/50 shadow-2xl flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
<img src="{{ asset('images/logo.png') }}" alt="PromptHub Logo" class="w-16 h-16 rounded-2xl shadow-lg shadow-rose-500/30 shrink-0">
                <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight mb-1">
                    Notifications
                </h1>
                <p class="text-slate-400 text-sm">Stay updated with your latest interactions and alerts.</p>
            </div>
        </div>

        @php
            $hasUnread = collect($notifications ?? [])->contains(fn($n) => ! $n->is_read);
        @endphp

        @if($hasUnread)
        <div class="relative z-10">
            <form action="{{ url('/notifications/mark-all-read') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="bg-slate-800 hover:bg-slate-700 text-white font-semibold px-5 py-2.5 rounded-xl border border-slate-600 transition-colors flex items-center gap-2 shadow-lg shadow-black/20">
                    <i data-lucide="check-check" class="w-4 h-4 text-slate-400"></i> Mark all as read
                </button>
            </form>
        </div>
        @endif

        <!-- Decorative glows -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 rounded-full bg-rose-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-pink-500/10 blur-3xl"></div>
    </div>

    <!-- Notifications List -->
    <div class="space-y-4">
        @forelse($notifications ?? [] as $notification)
            @php
                $isRead = $notification->is_read;
            @endphp
            <div class="relative group {{ $isRead ? 'bg-slate-900/20' : 'bg-slate-900/60' }} backdrop-blur-md border {{ $isRead ? 'border-slate-800/50' : 'border-rose-500/30' }} rounded-3xl p-5 hover:bg-slate-800/60 hover:border-rose-500/50 transition-all duration-300 flex items-start gap-4">
                
                @if(!$isRead)
                    <div class="absolute top-5 right-5 w-2 h-2 rounded-full bg-rose-500 shadow-[0_0_8px_rgba(244,63,94,0.8)]"></div>
                @endif

                <div class="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center shrink-0 border border-slate-700 overflow-hidden">
                    @if(isset($notification->data['user_avatar']) && $notification->data['user_avatar'])
                        <img src="{{ $notification->data['user_avatar'] }}" alt="Avatar" class="w-full h-full object-cover">
                    @else
                        <i data-lucide="bell" class="w-5 h-5 text-slate-400"></i>
                    @endif
                </div>

                <div class="flex-1 min-w-0 pt-1 relative z-20">
                    <p class="text-slate-300 text-sm leading-relaxed">
                        {!! $notification->data['message'] ?? 'You have a new notification.' !!}
                    </p>
                    <p class="text-xs text-slate-500 mt-2 flex items-center gap-1.5">
                        <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                        {{ $notification->created_at->diffForHumans() }}
                    </p>
                </div>

                @if(!$isRead)
                    <div class="relative z-30 ml-auto shrink-0">
                        <form action="{{ url('/notifications/' . $notification->id . '/mark-read') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="p-2 text-slate-400 hover:text-white bg-slate-800/50 hover:bg-slate-700 rounded-lg transition-colors border border-transparent hover:border-slate-600" title="Mark as read">
                                <i data-lucide="check" class="w-4 h-4 text-green-400"></i>
                            </button>
                        </form>
                    </div>
                @endif
                
                @if(isset($notification->data['url']))
                    <a href="{{ $notification->data['url'] }}" class="absolute inset-0 z-10" aria-label="View Notification"></a>
                @endif
            </div>
        @empty
            <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-16 text-center flex flex-col items-center justify-center shadow-lg">
                <div class="w-24 h-24 bg-slate-800/50 rounded-full flex items-center justify-center mb-6 border border-slate-700/50">
                    <i data-lucide="bell-off" class="w-12 h-12 text-slate-500"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-3">No Notifications</h3>
                <p class="text-slate-400 mb-0 max-w-md text-center">You're all caught up! You have no new notifications at this time.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection