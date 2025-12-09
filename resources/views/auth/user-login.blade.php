<!DOCTYPE html>
<html>

<head>
    <title>Login User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center h-screen bg-gray-100">
    <form id="loginForm" class="bg-white p-6 rounded shadow-md w-96" action="/login" method="POST">
        @csrf
        <h2 class="text-2xl font-bold mb-4">Login Guru</h2>

        <div id="errorMsg" class="text-red-500 mb-2 hidden"></div>

        <input id="email" type="email" name="email" placeholder="Email" class="w-full p-2 mb-4 border rounded"
            required>
        <input id="password" type="password" name="password" placeholder="Password"
            class="w-full p-2 mb-4 border rounded" required>

        <label class="flex items-center mb-4">
            <input type="checkbox" id="remember" class="mr-2">
            Remember Me
        </label>

        <button type="submit" class="w-full bg-orange-600 text-white p-2 rounded hover:bg-yellow-500">
            Login
        </button>
    </form>

    {{-- Pop up Notifikasi --}}
    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
            class="fixed top-5 right-5 bg-red-500 text-white px-4 py-2 rounded shadow-lg z-50">
            {{ session('error') }}
        </div>
    @endif
</body>

</html>
