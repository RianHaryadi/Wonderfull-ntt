<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? 'Login Admin' }}</title>
    @vite('resources/css/app.css')
    @livewireStyles

    <script>
        // Sync dark mode class with Filament theme or system preference
        const filamentTheme = localStorage.getItem('theme') ?? 'system';
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (filamentTheme === 'dark' || (filamentTheme === 'system' && prefersDark)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
    {{ $slot }}

    @livewireScripts
</body>
</html>
