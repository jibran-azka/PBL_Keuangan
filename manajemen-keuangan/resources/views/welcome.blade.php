<!DOCTYPE html>
<html lang="en" x-data="{ showLogin: false, showRegister: false }" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Keuangan</title>

    <!-- Font & Tailwind -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-indigo-600">Keuangan</h1>
            <div>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-indigo-600 font-semibold px-4">Dashboard</a>
                    @else
                        <button @click="showLogin = true" class="text-gray-600 hover:text-indigo-600 font-semibold px-4">Login</button>
                        @if (Route::has('register'))
                            <button @click="showRegister = true" class="ml-2 text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-md font-semibold">Daftar</button>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="mt-16 text-center px-6">
        <h2 class="text-4xl font-bold text-gray-900 mb-4">Atur Keuanganmu dengan Mudah</h2>
        <p class="text-gray-600 max-w-2xl mx-auto mb-8">Aplikasi manajemen keuangan sederhana untuk mencatat pemasukan, pengeluaran, dan Pengingat tagihan otomatis. Cocok untuk kebutuhan pribadi maupun tim kecil.</p>
        @guest
            <button @click="showLogin = true" class="bg-indigo-600 text-white px-6 py-3 rounded-md font-semibold hover:bg-indigo-700 transition">Mulai Sekarang</button>
        @endguest
    </section>

    <!-- Fitur Section -->
    <section class="mt-20 bg-white py-16">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10 px-6">
            <div class="bg-gray-100 p-6 rounded-lg shadow-sm">
                <h3 class="text-xl font-semibold mb-2">Catat Transaksi</h3>
                <p class="text-sm text-gray-600">Input pemasukan dan pengeluaran manual dengan kategori yang jelas.</p>
            </div>
            <div class="bg-gray-100 p-6 rounded-lg shadow-sm">
                <h3 class="text-xl font-semibold mb-2">Export Data Transaksi</h3>
                <p class="text-sm text-gray-600">Unduh catatan keuanganmu dalam format PDF atau Excel untuk laporan atau backup.</p>
            </div>
            <div class="bg-gray-100 p-6 rounded-lg shadow-sm">
                <h3 class="text-xl font-semibold mb-2">Notifikasi</h3>
                <p class="text-sm text-gray-600">Dapatkan pengingat sebelum tagihan jatuh tempo melalui email yang digunakan untuk mendaftar di web kami.</p>
            </div>
        </div>
    </section>

    <!-- Modal Login -->
    <div x-show="showLogin" x-transition class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div @click.away="showLogin = false" class="bg-white w-full max-w-md rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4 text-center">Login</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" required class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-indigo-500">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Password</label>
                    <input type="password" name="password" required class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-indigo-500">
                </div>
                <div class="flex items-center justify-between mb-4">
                    <label class="flex items-center text-sm">
                        <input type="checkbox" name="remember" class="mr-2"> Ingat Saya
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">Lupa Password?</a>
                    @endif
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 transition">Masuk</button>
            </form>
        </div>
    </div>

    <!-- Modal Register -->
    <div x-show="showRegister" x-transition class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div @click.away="showRegister = false" class="bg-white w-full max-w-md rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4 text-center">Daftar</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Nama</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-indigo-500">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" required class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-indigo-500">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Password</label>
                    <input type="password" name="password" required class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-indigo-500">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-indigo-500">
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 transition">Daftar</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-20 py-6 text-center text-gray-500 text-sm">
        &copy; {{ date('Y') }} Keuangan. All rights reserved.
    </footer>
</body>
</html>
