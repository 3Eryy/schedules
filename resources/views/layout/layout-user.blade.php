<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User</title>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <x-aset.top-bar-user />
    <x-aset.side-bar-user>
        <!-- Tempat halaman menampilkan konten -->
        @yield('content')
    </x-aset.side-bar-user>
</body>
</html>
