<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SiAP - Sistem Aplikasi Persediaan</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /* Include necessary styles, like Tailwind CSS */
            </style>
        @endif
    </head>
    <body class="font-sans antialiased dark:bg-gray-900 dark:text-gray-300">
        <div class="bg-gray-50 text-black/70 dark:bg-gray-900 dark:text-gray-300">
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-blue-500 selection:text-white">
                <div class="relative w-full max-w-4xl px-6 lg:px-10">
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                        <div class="flex lg:justify-center lg:col-start-2">
                            <h1 class="text-2xl font-bold text-blue-600 dark:text-blue-400">SiAP</h1>
                        </div>
                        @if (Route::has('login'))
                            <nav class="-mx-3 flex flex-1 justify-end">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="rounded-md px-3 py-2 text-blue-600 ring-1 ring-transparent transition hover:text-blue-800 focus:outline-none focus-visible:ring-blue-500 dark:text-blue-400 dark:hover:text-blue-500">
                                        Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-blue-600 ring-1 ring-transparent transition hover:text-blue-800 focus:outline-none focus-visible:ring-blue-500 dark:text-blue-400 dark:hover:text-blue-500">
                                        Log in
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="rounded-md px-3 py-2 text-blue-600 ring-1 ring-transparent transition hover:text-blue-800 focus:outline-none focus-visible:ring-blue-500 dark:text-blue-400 dark:hover:text-blue-500">
                                            Register
                                        </a>
                                    @endif
                                @endauth
                            </nav>
                        @endif
                    </header>

                    <main class="mt-6">
                        <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                            <a href="{{ url('/docs') }}" class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-md ring-1 ring-gray-200 transition duration-300 hover:text-blue-700 hover:ring-blue-500 focus:outline-none focus-visible:ring-blue-500 dark:bg-gray-800 dark:ring-gray-700 dark:hover:text-blue-400">
                                <div class="relative flex w-full items-center">
                                    <h2 class="text-xl font-semibold text-blue-600 dark:text-blue-400">Dokumentasi Sistem</h2>
                                </div>
                                <p class="mt-4 text-sm leading-relaxed">
                                    Panduan lengkap pengelolaan dan penggunaan aplikasi SiAP, mulai dari fitur pengajuan barang hingga laporan ketersediaan.
                                </p>
                            </a>

                            <a href="{{ url('/features') }}" class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-md ring-1 ring-gray-200 transition duration-300 hover:text-blue-700 hover:ring-blue-500 focus:outline-none focus-visible:ring-blue-500 dark:bg-gray-800 dark:ring-gray-700 dark:hover:text-blue-400">
                                <h2 class="text-xl font-semibold text-blue-600 dark:text-blue-400">Fitur Utama</h2>
                                <ul class="mt-4 text-sm leading-relaxed list-disc pl-5">
                                    <li>Pengajuan Permintaan Barang</li>
                                    <li>Validasi Permintaan oleh Supervisor</li>
                                    <li>Pengelolaan Stok Barang</li>
                                    <li>Laporan Ketersediaan Barang</li>
                                </ul>
                            </a>

                            <a href="{{ url('/about') }}" class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-md ring-1 ring-gray-200 transition duration-300 hover:text-blue-700 hover:ring-blue-500 focus:outline-none focus-visible:ring-blue-500 dark:bg-gray-800 dark:ring-gray-700 dark:hover:text-blue-400">
                                <h2 class="text-xl font-semibold text-blue-600 dark:text-blue-400">Tentang SiAP</h2>
                                <p class="mt-4 text-sm leading-relaxed">
                                    SiAP dirancang untuk membantu pengelolaan barang secara efisien, mudah digunakan, dan terstruktur, cocok untuk perusahaan berskala kecil.
                                </p>
                            </a>
                        </div>
                    </main>

                    <footer class="py-6 text-center text-sm text-gray-600 dark:text-gray-500">
                        © 2024 SiAP. Dibangun dengan Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
