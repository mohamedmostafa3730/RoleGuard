<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practice App | Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white text-gray-900 font-sans">

    <!-- Navigation -->
    <nav class="flex items-center justify-between px-8 py-6 border-b border-gray-100">
        <div class="text-2xl font-bold text-blue-600 tracking-tighter">
            PRACTICE<span class="text-gray-900">APP</span>
        </div>
        <div class="space-x-4">
            @auth
            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600 font-medium">Dashboard</a>
            @else
            <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium">Login</a>
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="max-w-6xl mx-auto px-8 py-20 lg:py-32 flex flex-col items-center text-center">
        <h1 class="text-5xl lg:text-7xl font-extrabold tracking-tight mb-6">
            Mastering <span class="text-blue-600">Roles & Permissions</span>
        </h1>
        <p class="text-xl text-gray-500 max-w-2xl mb-10">
            This is a practice project integrating Laravel Sanctum, Spatie Permissions, and Media Library into one
            seamless Admin Panel experience.
        </p>
        <div class="flex space-x-4">
            <a href="{{ route('login') }}"
                class="bg-gray-900 text-white px-8 py-3 rounded-lg font-bold hover:bg-gray-800 transition shadow-lg">
                Enter Admin Panel
            </a>
        </div>
    </header>

    <!-- Tech Stack Grid -->
    <section class="bg-gray-50 py-20">
        <div class="max-w-6xl mx-auto px-8">
            <h2 class="text-center text-sm font-semibold text-gray-400 uppercase tracking-widest mb-12">Built With
                Industry Standards</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-8 bg-white rounded-2xl shadow-sm">
                    <div class="text-blue-600 text-3xl mb-4 font-bold">01</div>
                    <h3 class="text-xl font-bold mb-2">Sanctum</h3>
                    <p class="text-gray-500">Secure API authentication for mobile and SPA consumers.</p>
                </div>
                <div class="p-8 bg-white rounded-2xl shadow-sm">
                    <div class="text-blue-600 text-3xl mb-4 font-bold">02</div>
                    <h3 class="text-xl font-bold mb-2">Spatie Roles</h3>
                    <p class="text-gray-500">Fine-grained access control using roles and permissions.</p>
                </div>
                <div class="p-8 bg-white rounded-2xl shadow-sm">
                    <div class="text-blue-600 text-3xl mb-4 font-bold">03</div>
                    <h3 class="text-xl font-bold mb-2">Media Library</h3>
                    <p class="text-gray-500">Advanced file management and polymorphic media attachments.</p>
                </div>
            </div>
        </div>
    </section>

</body>

</html>