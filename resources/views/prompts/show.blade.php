@extends('layouts.app')

@section('content')

    {{-- Replaced manual HTML with your new reusable toast component --}}
    <x-toast />

    <div class="w-full">
        <div class="mb-6">

            @if($prompt->is_featured)

                <div class="mb-4">

                    <span class="bg-yellow-500/20 text-yellow-400 px-4 py-2 rounded-lg font-semibold">
                        <i data-lucide="star" class="w-4 h-4 inline-block mb-1"></i>
                        Featured 
                    </span>

                </div>

            @endif
            <h1 class="text-5xl font-bold mb-4 text-white">
                {{ $prompt->title }}
            </h1>

            <div class="text-slate-400">
                Category: {{ optional($prompt->category)->name ?? 'Uncategorized' }}
            </div>

            <div class="flex items-center gap-5 text-slate-500 mt-3">
                <div class="flex items-center gap-2">
                    <i data-lucide="eye" class="w-4 h-4"></i>
                    <span>
                        {{ $prompt->views_count }} views
                    </span>
                </div>

                <div class="flex items-center gap-2">
                    <i data-lucide="copy" class="w-4 h-4"></i>
                    <span id="copyCount-{{ $prompt->id }}">
                        {{ $prompt->copy_count }} copies
                    </span>
                </div>
            </div>

            <div class="flex flex-wrap gap-2 mt-4">
                @foreach ($prompt->tags as $tag)
                    <a href="/tags/{{ $tag->slug }}"
                        class="px-3 py-1 bg-slate-800 hover:bg-blue-500 rounded-full text-sm text-slate-300 hover:text-white transition">
                        #{{ $tag->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="bg-slate-900 border border-slate-800 rounded-xl p-6">

            {{-- Prompt Content Container --}}
            <div class="relative bg-slate-950 rounded-xl border border-slate-800 overflow-hidden mb-6">

                {{-- Action Icons (Heart & Copy) --}}
                <div class="absolute top-4 right-4 flex items-center gap-3 z-10 bg-slate-950/80 p-1 rounded-md">

                    {{-- Favorite Toggle Button --}}
                    <form action="/favorites/{{ $prompt->id }}" method="POST" class="m-0">
                        @csrf
                        @if ($prompt->isFavorited())
                            @method('DELETE')
                        @endif
                        <button type="submit" class="p-1 text-slate-400 hover:text-red-500 transition"
                            title="{{ $prompt->isFavorited() ? 'Unfavorite' : 'Favorite' }}">
                            <i data-lucide="heart"
                                class="w-5 h-5 {{ $prompt->isFavorited() ? 'fill-red-500 text-red-500' : '' }}">
                            </i>
                        </button>
                    </form>

                    {{-- Copy Button --}}
                    <button id="copyButton-{{ $prompt->id }}" onclick="copyPrompt({{ $prompt->id }})"
                        class="p-1 text-slate-400 hover:text-white transition" title="Copy prompt">
                        <span id="icon-copy-{{ $prompt->id }}">
                            <i data-lucide="copy" class="w-5 h-5"></i>
                        </span>
                        <span id="icon-check-{{ $prompt->id }}" class="hidden">
                            <i data-lucide="check" class="w-5 h-5 text-green-500"></i>
                        </span>
                    </button>
                </div>

                {{-- Prompt Text --}}
                <div id="promptContent-{{ $prompt->id }}"
                    class="break-words text-slate-200 font-sans text-lg leading-relaxed p-6 pr-24 m-0">
                    {!! nl2br(e(trim($prompt->prompt_content))) !!}
                </div>

                <div class="mt-8 bg-slate-900 border border-slate-800 rounded-xl p-6">

                    <div class="mb-4">

                        <span class="text-yellow-400 text-2xl">
                            <i data-lucide="star" class="w-5 h-5 inline-block"></i>
                            <!-- {{ $prompt->averageRating() ?: 'No ratings yet' }} -->
                        </span>

                        <span class="text-xl font-bold">
                            {{ $prompt->averageRating() ?: 'No ratings yet' }}
                        </span>

                        <span class="text-slate-400">
                            ({{ $prompt->ratings()->count() }} ratings)
                        </span>

                    </div>

                    <form action="/prompts/{{ $prompt->id }}/rate" method="POST"
                        class="relative z-10 mt-3 flex items-center gap-1 flex-row-reverse [&>button]:text-slate-500 [&>button]:transition [&>button:hover]:text-yellow-400 [&>button:focus-visible]:text-yellow-400 [&>button:hover~button]:text-yellow-400 [&>button:focus-visible~button]:text-yellow-400">
                        @csrf
                        @for ($i = 5; $i >= 1; $i--)
                            <button type="submit" name="rating" value="{{ $i }}" aria-label="Rate {{ $i }} stars">
                                <i data-lucide="star" class="w-4 h-4"></i>
                            </button>
                        @endfor
                    </form>

                </div>

            </div>

            {{-- FIXED: Moved 'Save to Collection' OUTSIDE the prompt text box --}}
            @auth
                <div class="pt-4 border-t border-slate-800">
                    <h3 class="text-lg font-semibold mb-4 text-white">
                        Save to Collection
                    </h3>

                    <div class="flex flex-wrap gap-3">
                        @forelse(auth()->user()->collections as $collection)
                            <form action="{{ route('collections.prompts.store', [$collection, $prompt]) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit"
                                    class="px-4 py-2 bg-slate-800 hover:bg-blue-500 text-slate-300 hover:text-white rounded-lg text-sm transition">
                                    + {{ $collection->name }}
                                </button>
                            </form>
                        @empty
                            <p class="text-slate-500 text-sm">
                                You don't have any collections yet. <a href="/collections"
                                    class="text-blue-500 hover:underline">Create one</a>.
                            </p>
                        @endforelse
                    </div>
                </div>
            @endauth

        </div>

        <div class="mt-10">

            <h2 class="text-3xl font-bold mb-6">
                Comments
                ({{ $prompt->comments->count() }})
            </h2>

            <form action="/prompts/{{ $prompt->id }}/comments" method="POST" class="mb-6">
                @csrf

                <textarea name="content" rows="4" placeholder="Write a comment..."
                    class="w-full bg-slate-900 border border-slate-800 rounded-xl p-4" required></textarea>

                <button class="mt-3 bg-blue-500 hover:bg-blue-600 px-5 py-3 rounded-xl font-semibold">
                    Post Comment
                </button>

            </form>

            <div class="space-y-4">

                @forelse($prompt->comments()->latest()->get() as $comment)

                    <div class="bg-slate-900 border border-slate-800 rounded-xl p-5">

                        <div class="flex items-center justify-between gap-4 mb-2">
                            <div class="font-bold">
                                {{ $comment->user->name }}
                            </div>

                            @auth
                                @if(auth()->id() === $comment->user_id || auth()->id() === $prompt->user_id)
                                    <form action="/prompts/{{ $prompt->id }}/comments/{{ $comment->id }}" method="POST" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-400 hover:text-red-300 transition">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>

                        <div class="text-slate-300">
                            {{ $comment->content }}
                        </div>

                    </div>

                @empty

                    <div class="text-slate-400">
                        No comments yet.
                    </div>

                @endforelse

            </div>

        </div>
    </div>
@endsection
