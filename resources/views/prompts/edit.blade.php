@extends('layouts.app')

@section('content')

<div class="w-full">

    <h1 class="text-4xl font-bold mb-6">
        Edit Prompt
    </h1>

    <form
        action="{{ route('prompts.update', $prompt) }}"
        method="POST"
        class="space-y-6"
    >

        @csrf
        @method('PUT')

        <div>

            <label class="block mb-2">
                Title
            </label>

            <input
                type="text"
                name="title"
                value="{{ old('title', $prompt->title) }}"
                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3"
            >
            @error('title') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror

        </div>

        <div>

            <label class="block mb-2">
                Category
            </label>

            <select
                name="category_id"
                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3"
            >

                @foreach($categories as $category)

                    <option
                        value="{{ $category->id }}"
                        {{ old('category_id', $prompt->category_id) == $category->id ? 'selected' : '' }}
                    >
                        {{ $category->name }}
                    </option>

                @endforeach

            </select>

        </div>

        <div>

            <label class="block mb-2">
                Content
            </label>

            <textarea
                name="content"
                rows="10"
                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3"
            >{{ old('content', $prompt->prompt_content) }}</textarea>
            @error('content') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror

        </div>

        <div>

            <label class="block mb-2">
                Tags
            </label>

            <input
                type="text"
                name="tags"
                value="{{ old('tags', $prompt->tags->pluck('name')->implode(', ')) }}"
                placeholder="ai, image, coding"
                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3"
            >

            <p class="text-slate-500 text-sm mt-2">
                Separate tags with commas.
            </p>
        </div>

        <button class="bg-blue-500 hover:bg-blue-600 px-6 py-3 rounded-lg font-semibold">
            Update Prompt
        </button>

    </form>

</div>

@endsection
