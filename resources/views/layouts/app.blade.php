<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'PromptHub' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-950 text-white min-h-screen">

    <div class="flex min-h-screen">

        <aside class="w-64 bg-slate-900 border-r border-slate-800 p-6 sticky top-0 h-screen overflow-y-auto">

            <div class="mt-4">

                <a href="/"
                    class="inline-flex items-center gap-2 text-sm text-slate-400 hover:text-white transition duration-200">

                    <h1 class="text-2xl font-bold text-blue-500">
                        PromptHub
                    </h1>
                </a>

            </div>


            <nav class="mt-10 space-y-4">

                @auth
                <a href="/dashboard" class="flex items-center gap-3 block text-slate-300 hover:text-blue-500">

                    <i data-lucide="home" class="w-5 h-5"></i>

                    Dashboard
                </a>

                <a href="/prompts" class="flex items-center gap-3 block text-slate-300 hover:text-blue-500">

                    <i data-lucide="file-text" class="w-5 h-5"></i>

                    My Prompts
                </a>

                <a href="/explore" class="flex items-center gap-3 block text-slate-300 hover:text-blue-500">

                    <i data-lucide="compass" class="w-5 h-5"></i>

                    Explore
                </a>

                <a href="/trending" class="flex items-center gap-3 text-slate-300 hover:text-blue-500 transition">

                    <i data-lucide="flame"></i>

                    Trending

                </a>

                <a href="/leaderboard" class="flex items-center gap-3 text-slate-300 hover:text-blue-500 transition">

                    <i data-lucide="award" class="w-5 h-5"></i>

                    <span>
                        Leaderboard
                    </span>

                </a>

                <a href="/favorites" class="flex items-center gap-3 text-slate-300 hover:text-blue-500 transition">

                    <i data-lucide="heart" class="w-5 h-5"></i>

                    Favorites

                </a>

                <a href="/notifications" class="flex items-center gap-3 text-slate-300 hover:text-blue-500 transition relative">

                    <i data-lucide="bell" class="w-5 h-5"></i>

                    Notifications
                    @php $unreadCount = auth()->check() ? auth()->user()->notifications()->where('is_read', false)->count() : 0; @endphp
                    @if($unreadCount > 0)
                        <span class="absolute -top-1.5 -right-1.5 min-w-[18px] h-[18px] px-1 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center leading-none shadow-lg shadow-red-500/30">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
                    @endif

                </a>

                <a href="/collections" class="flex items-center gap-3 text-slate-300 hover:text-blue-500 transition">

                    <i data-lucide="folder" class="w-5 h-5"></i>

                    <span>
                        Collections
                    </span>

                </a>

                <a href="/top-rated" class="flex items-center gap-3 text-slate-300 hover:text-blue-500 transition">

                    <i data-lucide="star" class="w-5 h-5"></i>

                    <span>
                        Top Rated
                    </span>

                </a>

                <a href="/analytics" class="flex items-center gap-3 text-slate-300 hover:text-blue-500 transition">

                    <i data-lucide="bar-chart" class="w-5 h-5"></i>

                    <span>
                        Analytics
                    </span>

                </a>


                <a href="/ai-generator" class="flex items-center gap-3 text-slate-300 hover:text-blue-500 transition">
                    <i data-lucide="sparkles" class="w-5 h-5"></i>
                    AI Generator
                </a>


                <a href="/profile" class="flex items-center gap-3 text-slate-300 hover:text-blue-500 transition">

                    <i data-lucide="user" class="w-5 h-5"></i>

                    Profile

                </a>
                @if(auth()->user()->is_admin)

                    <a href="/admin" class="flex items-center gap-3 text-slate-300 hover:text-blue-500 transition">
                        <i data-lucide="shield"></i>
                        Admin
                    </a>

                @endif

                <a href="{{ route('settings.edit') }}" class="flex items-center gap-3 text-slate-300 hover:text-blue-500 transition">
                    <i data-lucide="settings"></i>
                    Settings
                </a>

                <form method="POST" action="{{ route('logout') }}" class="pt-6 mt-6 border-t border-slate-800/50">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 text-slate-400 hover:text-rose-400 transition group">
                        <i data-lucide="log-out" class="w-5 h-5 group-hover:-translate-x-1 transition-transform"></i>
                        Log Out
                    </button>
                </form>
                @else
                <a href="/leaderboard" class="flex items-center gap-3 text-slate-300 hover:text-blue-500 transition">
                    <i data-lucide="award" class="w-5 h-5"></i>
                    <span>Leaderboard</span>
                </a>

                <a href="/login" class="flex items-center gap-3 text-slate-300 hover:text-blue-500 transition">
                    <i data-lucide="log-in" class="w-5 h-5"></i>
                    Login
                </a>

                <a href="/register" class="flex items-center gap-3 text-slate-300 hover:text-blue-500 transition">
                    <i data-lucide="user-plus" class="w-5 h-5"></i>
                    Register
                </a>
                @endauth


            </nav>

        </aside>

        <main class="flex-1 p-8">

            @yield('content')

        </main>

    </div>

    <x-toast />

@php
    $lastMsg = null;
    $conversationsJson = '[]';
    if (auth()->check()) {
        $lastConv = \App\Models\Conversation::where('user_id', auth()->id())
            ->whereHas('messages', function ($q) { $q->where('role', 'assistant'); })
            ->with(['messages' => function ($q) { $q->where('role', 'assistant')->latest()->limit(1); }])
            ->latest()
            ->first();
        if ($lastConv && $lastConv->messages->isNotEmpty()) {
            $lastMsg = $lastConv->messages->first()->content;
        }
        $allConvs = \App\Models\Conversation::where('user_id', auth()->id())
            ->latest()
            ->get(['id', 'title', 'created_at']);
        $conversationsJson = $allConvs->toJson();
    }
@endphp

    <div id="aiFabContainer" class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3"
         data-last-msg="{{ $lastMsg ? e($lastMsg) : '' }}"
         data-conversations="{{ e($conversationsJson) }}">
        <button id="aiFabBtn" type="button"
            class="w-14 h-14 bg-gradient-to-br from-violet-500 to-fuchsia-600 hover:from-violet-400 hover:to-fuchsia-500 rounded-full flex items-center justify-center shadow-lg shadow-violet-500/40 transition-all duration-300 hover:scale-110 group relative">
            <div class="absolute inset-0 rounded-full bg-white/20 animate-ping opacity-0 group-hover:opacity-100"></div>
            <i data-lucide="bot" class="w-7 h-7 text-white relative z-10 group-hover:animate-bounce"></i>
        </button>

        <div id="aiFabLoading" class="hidden bg-slate-900/90 backdrop-blur-md border border-slate-700/50 rounded-2xl px-5 py-3 shadow-xl flex items-center gap-3">
            <svg class="animate-spin h-5 w-5 text-violet-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            <span class="text-sm font-medium text-slate-200">Initializing AI...</span>
        </div>

        <div id="aiFabChat" class="hidden bg-slate-900/95 backdrop-blur-2xl border border-slate-700/50 rounded-2xl overflow-hidden shadow-[0_0_50px_-12px_rgba(139,92,246,0.25)] w-[22rem] sm:w-[24rem] flex flex-col transition-all duration-300 mb-2">
            <div class="flex items-center justify-between bg-gradient-to-r from-slate-800 to-slate-800/80 px-5 py-4 border-b border-slate-700/50">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-violet-500 to-fuchsia-600 flex items-center justify-center shadow-md shadow-violet-500/20">
                        <i data-lucide="sparkles" class="w-4 h-4 text-white"></i>
                    </div>
                    <div>
                        <span class="font-bold text-sm text-white block leading-tight">AI Assistant</span>
                        <span class="text-[10px] text-violet-400 font-medium flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Online</span>
                    </div>
                </div>
                <div class="flex items-center gap-0.5">
                    <button id="historyFab" type="button" class="text-slate-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition p-1.5" title="History">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                    </button>
                    <button id="clearChatFab" type="button" class="text-slate-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition p-1.5" title="Clear Chat">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                    <button id="newChatFab" type="button" class="text-slate-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition p-1.5" title="New Chat">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                    </button>
                    <button id="maximizeAiFab" type="button" class="text-slate-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition p-1.5" title="Maximize">
                        <i data-lucide="maximize-2" class="w-4 h-4"></i>
                    </button>
                    <button id="closeAiFab" type="button" class="text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 rounded-lg transition p-1.5" title="Close">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <div id="aiFabMessages" class="h-[22rem] sm:h-96 overflow-y-auto p-4 space-y-4 text-sm scroll-smooth"></div>

            <div id="aiFabHistory" class="hidden h-[22rem] sm:h-96 overflow-y-auto p-4 space-y-2 text-sm">
                <div class="flex items-center justify-between mb-3">
                    <span class="font-semibold text-slate-300">Conversations</span>
                    <button id="closeHistoryFab" type="button" class="text-slate-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition p-1.5">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
                <div id="historyList" class="space-y-1"></div>
            </div>

            <div class="border-t border-slate-700/50 p-3 bg-slate-800/30 flex gap-2">
                <input id="aiFabInput" type="text" placeholder="Ask me anything..."
                    class="flex-1 bg-slate-900/50 border border-slate-600/50 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 transition-all shadow-inner">
                <button id="aiFabSend" type="button"
                    class="bg-violet-600 hover:bg-violet-500 text-white w-10 h-10 rounded-xl flex items-center justify-center shadow-lg shadow-violet-500/20 transition-all hover:scale-105 group shrink-0">
                    <i data-lucide="send" class="w-4 h-4 group-hover:-translate-y-0.5 group-hover:translate-x-0.5 transition-transform"></i>
                </button>
            </div>
        </div>
    </div>

<script src="https://unpkg.com/lucide@latest"></script>

<script>
    lucide.createIcons();
</script>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var fabBtn = document.getElementById('aiFabBtn');
    if (!fabBtn) return;

    var loading = document.getElementById('aiFabLoading');
    var chatContainer = document.getElementById('aiFabChat');
    var chatMessages = document.getElementById('aiFabMessages');
    var chatInput = document.getElementById('aiFabInput');
    var chatSend = document.getElementById('aiFabSend');
    var closeBtn = document.getElementById('closeAiFab');
    var newChatBtn = document.getElementById('newChatFab');
    var clearChatBtn = document.getElementById('clearChatFab');
    var maximizeBtn = document.getElementById('maximizeAiFab');
    var historyBtn = document.getElementById('historyFab');
    var historyPanel = document.getElementById('aiFabHistory');
    var historyList = document.getElementById('historyList');
    var closeHistoryBtn = document.getElementById('closeHistoryFab');

    var conversationId = null;
    var lastMsg = chatContainer.closest('[data-last-msg]')?.dataset.lastMsg;

    fabBtn.addEventListener('click', function () {
        fabBtn.classList.add('hidden');
        loading.classList.remove('hidden');

        setTimeout(function () {
            loading.classList.add('hidden');
            chatContainer.classList.remove('hidden');
            if (window.lucide) window.lucide.createIcons();
            if (lastMsg) {
                addMessage('assistant', lastMsg);
            } else {
                addMessage('assistant', 'Hi! How can I help you?');
            }
            chatInput.focus();
        }, 800);
    });

    clearChatBtn.addEventListener('click', function () {
        chatMessages.innerHTML = '';
        conversationId = null;
        addMessage('assistant', 'Chat cleared. Start a new conversation!');
        if (window.lucide) window.lucide.createIcons();
    });

    newChatBtn.addEventListener('click', function () {
        if (isMaximized) toggleMaximize();
        chatMessages.innerHTML = '';
        conversationId = null;
        addMessage('assistant', 'Hi! How can I help you?');
        if (window.lucide) window.lucide.createIcons();
    });

    closeBtn.addEventListener('click', function () {
        if (isMaximized) toggleMaximize();
        chatContainer.classList.add('hidden');
        fabBtn.classList.remove('hidden');
        chatMessages.innerHTML = '';
        conversationId = null;
        if (window.lucide) window.lucide.createIcons();
    });

    historyBtn.addEventListener('click', function () {
        chatMessages.classList.add('hidden');
        historyPanel.classList.remove('hidden');
        historyList.innerHTML = '<p class="text-slate-500 text-center py-4">Loading...</p>';
        fetch('/chat/messages-list')
            .then(function (r) { return r.json(); })
            .then(function (convs) {
                historyList.innerHTML = '';
                if (convs.length === 0) {
                    historyList.innerHTML = '<p class="text-slate-500 text-center py-4">No conversations yet.</p>';
                } else {
                    convs.forEach(function (c) {
                        var row = document.createElement('div');
                        row.className = 'flex items-center gap-2 bg-slate-800 hover:bg-slate-700 rounded-lg px-3 py-2 transition';

                        var a = document.createElement('button');
                        a.type = 'button';
                        a.className = 'min-w-0 flex-1 text-left';
                        a.innerHTML = '<div class="text-xs font-medium truncate">' + escapeHtml(c.title || 'Untitled') + '</div><div class="text-[10px] text-slate-500">' + new Date(c.created_at).toLocaleDateString() + '</div>';
                        a.addEventListener('click', function () { loadConversation(c.id); });

                        var deleteBtn = document.createElement('button');
                        deleteBtn.type = 'button';
                        deleteBtn.className = 'shrink-0 rounded-md p-1.5 text-red-500 hover:bg-red-500/10 hover:text-red-400 transition';
                        deleteBtn.title = 'Delete Conversation';
                        deleteBtn.setAttribute('aria-label', 'Delete Conversation');
                        deleteBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>';
                        deleteBtn.addEventListener('click', function (e) {
                            e.stopPropagation();
                            deleteConversation(c.id, row);
                        });

                        row.appendChild(a);
                        row.appendChild(deleteBtn);
                        historyList.appendChild(row);
                    });
                }
                if (window.lucide) window.lucide.createIcons();
            });
    });

    closeHistoryBtn.addEventListener('click', function () {
        historyPanel.classList.add('hidden');
        chatMessages.classList.remove('hidden');
    });

    function loadConversation(id) {
        fetch('/chat/messages/' + id)
            .then(function (r) { return r.json(); })
            .then(function (data) {
                chatMessages.innerHTML = '';
                data.messages.forEach(function (m) {
                    addMessage(m.role, m.content);
                });
                conversationId = id;
                historyPanel.classList.add('hidden');
                chatMessages.classList.remove('hidden');
            });
    }

    function deleteConversation(id, row) {
        if (!confirm('Delete this conversation?')) return;

        var deleteBtn = row.querySelector('button[aria-label="Delete Conversation"]');
        if (deleteBtn) {
            deleteBtn.disabled = true;
            deleteBtn.innerHTML = '<svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>';
            deleteBtn.classList.add('cursor-not-allowed', 'opacity-60');
        }

        fetch('/chat/messages/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
        })
        .then(function (r) {
            if (!r.ok) throw new Error('Delete failed');
            row.remove();

            if (String(conversationId) === String(id)) {
                conversationId = null;
                chatMessages.innerHTML = '';
                addMessage('assistant', 'Conversation deleted. Start a new conversation!');
            }

            if (!historyList.children.length) {
                historyList.innerHTML = '<p class="text-slate-500 text-center py-4">No conversations yet.</p>';
            }
        })
        .catch(function () {
            if (deleteBtn) {
                deleteBtn.disabled = false;
                deleteBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>';
                deleteBtn.classList.remove('cursor-not-allowed', 'opacity-60');
            }
            alert('Could not delete this conversation. Please try again.');
        });
    }

    function escapeHtml(text) {
        var d = document.createElement('div');
        d.textContent = text;
        return d.innerHTML;
    }

    var isMaximized = false;

    maximizeBtn.addEventListener('click', toggleMaximize);

    function toggleMaximize() {
        isMaximized = !isMaximized;
        if (isMaximized) {
            chatContainer.classList.remove('w-[22rem]', 'sm:w-[24rem]');
            chatContainer.classList.add('fixed', 'top-0', 'right-0', 'bottom-0', 'left-64', 'w-auto', 'h-auto', 'rounded-none');
            chatMessages.classList.remove('h-[22rem]', 'sm:h-96');
            chatMessages.classList.add('flex-1', 'min-h-0');
            chatContainer.querySelectorAll('[class*="max-w-xs"]').forEach(function (el) {
                el.classList.remove('max-w-xs');
                el.classList.add('max-w-full');
            });
            maximizeBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="4 14 4 20 10 20"/><polyline points="20 10 20 4 14 4"/><line x1="14" y1="10" x2="21" y2="3"/><line x1="3" y1="21" x2="10" y2="14"/></svg>';
        } else {
            chatContainer.classList.remove('fixed', 'top-0', 'right-0', 'bottom-0', 'left-64', 'w-auto', 'h-auto', 'rounded-none');
            chatContainer.classList.add('w-[22rem]', 'sm:w-[24rem]');
            chatMessages.classList.remove('flex-1', 'min-h-0');
            chatMessages.classList.add('h-[22rem]', 'sm:h-96');
            chatContainer.querySelectorAll('[class*="max-w-full"]').forEach(function (el) {
                el.classList.remove('max-w-full');
                el.classList.add('max-w-xs');
            });
            maximizeBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/><line x1="21" y1="3" x2="14" y2="10"/><line x1="3" y1="21" x2="10" y2="14"/></svg>';
        }
    }

    chatSend.addEventListener('click', sendMessage);
    chatInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') sendMessage();
    });

    function sendMessage() {
        var message = chatInput.value.trim();
        if (!message) return;

        addMessage('user', message);
        chatInput.value = '';
        chatInput.disabled = true;
        chatSend.disabled = true;

        var loadingMsg = document.createElement('div');
        loadingMsg.className = 'flex items-center gap-2 py-2';
        loadingMsg.innerHTML = '<div class="bg-slate-800/80 border border-slate-700/50 px-4 py-3 rounded-2xl rounded-tl-sm shadow-sm"><div class="flex gap-1.5 items-center h-4"><div class="w-2 h-2 bg-violet-400/80 rounded-full animate-bounce"></div><div class="w-2 h-2 bg-violet-400/80 rounded-full animate-bounce" style="animation-delay: 0.15s"></div><div class="w-2 h-2 bg-violet-400/80 rounded-full animate-bounce" style="animation-delay: 0.3s"></div></div></div>';
        loadingMsg.id = 'aiFabLoadingMsg';
        chatMessages.appendChild(loadingMsg);
        chatMessages.scrollTop = chatMessages.scrollHeight;

        var body = { message: message };
        if (conversationId) body.conversation = conversationId;

        fetch('/chat/send-ajax', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify(body),
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            var el = document.getElementById('aiFabLoadingMsg');
            if (el) el.remove();
            addMessage('assistant', data.response);
            conversationId = data.conversation;
        })
        .catch(function () {
            var el = document.getElementById('aiFabLoadingMsg');
            if (el) el.remove();
            addMessage('assistant', 'Sorry, something went wrong. Please try again.');
        })
        .finally(function () {
            chatInput.disabled = false;
            chatSend.disabled = false;
            chatInput.focus();
        });
    }

    function addMessage(role, content) {
        var div = document.createElement('div');
        div.className = role === 'user' ? 'flex justify-end' : 'flex justify-start';

        var sizeClass = isMaximized ? 'max-w-full' : 'max-w-xs';
        var bubble = document.createElement('div');
        bubble.className = role === 'user'
            ? 'bg-gradient-to-br from-violet-500 to-fuchsia-600 text-white px-4 py-2.5 rounded-2xl rounded-tr-sm shadow-md ' + sizeClass + ' [&_pre]:bg-violet-700/50'
            : 'bg-slate-800/80 border border-slate-700/50 text-slate-200 px-4 py-2.5 rounded-2xl rounded-tl-sm shadow-sm ' + sizeClass;

        if (role === 'assistant') {
            bubble.innerHTML = renderMd(content);
            bubble.querySelectorAll('pre code').forEach(function (code) {
                if (window.hljs) window.hljs.highlightElement(code);
            });
            bubble.querySelectorAll('pre').forEach(function (pre) {
                if (pre.querySelector('.copy-btn')) return;
                var btn = document.createElement('button');
                btn.className = 'copy-btn absolute top-1 right-1 p-1 rounded-md text-slate-400 hover:text-white';
                btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>';
                pre.classList.add('relative');
                pre.appendChild(btn);
            });
        } else {
            bubble.textContent = content;
        }

        div.appendChild(bubble);
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function renderMd(text) {
        text = text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        text = text.replace(/```(\w*)\n?([\s\S]*?)```/g, function (_, lang, code) {
            var langAttr = lang ? ' class="language-' + lang + '"' : '';
            return '<pre class="relative overflow-x-auto"><code' + langAttr + '>' + code.trim() + '</code></pre>';
        });
        text = text.replace(/`([^`]+)`/g, '<code class="bg-slate-700 px-1 rounded text-violet-300 text-xs">$1</code>');
        text = text.replace(/\*\*(.+?)\*\*/g, '<strong class="text-white">$1</strong>');
        text = text.replace(/\*(.+?)\*/g, '<em>$1</em>');
        text = text.replace(/\n/g, '<br>');
        return text;
    }

    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.copy-btn');
        if (!btn) return;
        var codeEl = btn.parentElement.querySelector('code');
        if (!codeEl) return;
        var text = codeEl.innerText;
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(function () {
                btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>';
                setTimeout(function () {
                    btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>';
                }, 2000);
            }).catch(function () {
                fallbackCopy(text, btn);
            });
        } else {
            fallbackCopy(text, btn);
        }
    });

    function fallbackCopy(text, btn) {
        var ta = document.createElement('textarea');
        ta.value = text;
        ta.style.position = 'fixed';
        ta.style.opacity = '0';
        document.body.appendChild(ta);
        ta.select();
        try {
            document.execCommand('copy');
            btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>';
            setTimeout(function () {
                btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>';
            }, 2000);
        } catch (err) {
            console.error('Copy failed:', err);
        }
        document.body.removeChild(ta);
    }
});
</script>
@endpush

@stack('scripts')

</body>

</html>
