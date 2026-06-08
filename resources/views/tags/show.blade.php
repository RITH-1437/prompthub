@extends('layouts.app')

@section('content')

<div class="max-w-5xl">

    <div class="mb-8">

        <h1 class="text-4xl font-bold text-white mb-3">
            #{{ $tag->name }}
        </h1>

        <p class="text-slate-400">
            Prompts tagged with {{ $tag->name }}
        </p>

    </div>

    <div class="space-y-4">

        @forelse($prompts as $prompt)

            <a href="/prompts/{{ $prompt->id }}"
               class="block bg-slate-900 border border-slate-800 rounded-xl p-6 hover:border-blue-500 transition">

                <h2 class="text-2xl font-semibold text-white mb-3">
                    {{ $prompt->title }}
                </h2>

                <p class="text-slate-400 line-clamp-2">
                    {{ Str::limit($prompt->prompt_content, 140) }}
                </p>

            </a>

        @empty

            <div class="text-slate-400">
                No prompts found.
            </div>

        @endforelse

    </div>

</div>

@endsection