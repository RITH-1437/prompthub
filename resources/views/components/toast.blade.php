@php
    $toasts = [
        'success' => [
            'message' => session('success'),
            'classes' => 'bg-green-500/10 border-green-500 text-green-200',
            'icon' => 'check-circle',
        ],
        'error' => [
            'message' => session('error'),
            'classes' => 'bg-red-500/10 border-red-500 text-red-200',
            'icon' => 'x-circle',
        ],
        'warning' => [
            'message' => session('warning'),
            'classes' => 'bg-yellow-500/10 border-yellow-500 text-yellow-200',
            'icon' => 'alert-triangle',
        ],
    ];
@endphp

@php
    $activeToasts = array_filter($toasts, fn ($toast) => !empty($toast['message']));
@endphp

@if(count($activeToasts))
    <div class="fixed top-4 sm:top-6 right-4 sm:right-6 z-50 flex flex-col-reverse gap-3 max-w-[calc(100vw-2rem)] sm:max-w-none">
        @foreach($activeToasts as $toast)
            <div
                class="toast border px-5 py-4 rounded-xl shadow-xl flex items-center gap-3 {{ $toast['classes'] }}"
            >
                <i data-lucide="{{ $toast['icon'] }}" class="w-5 h-5"></i>
                <div>
                    {{ $toast['message'] }}
                </div>
            </div>
        @endforeach
    </div>
@endif