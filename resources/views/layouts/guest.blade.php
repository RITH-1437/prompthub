<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'PromptHub' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}?v=1">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}?v=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-slate-950 text-white flex items-center justify-center min-h-screen">

    @yield('content')

    <x-toast />

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>