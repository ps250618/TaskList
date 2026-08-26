{{-- 'resources/views/layouts/app.blade.php' --}}
    <!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'App' }}</title>
    @livewireStyles
</head>
<body>
<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
<livewire:livewire-ui-modal />

@livewireScripts
</body>
</html>

