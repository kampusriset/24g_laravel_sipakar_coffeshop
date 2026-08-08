<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login - Nusaroma</title>

        <script src="https://cdn.tailwindcss.com"></script>

        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">

        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap"
            rel="stylesheet">

        <style>

            body{

                font-family:'Manrope',sans-serif;

            }

        </style>

    </head>

    <body class="bg-white">

    <div class="min-h-screen grid lg:grid-cols-5">

        {{-- LEFT: Branding (lebih kecil, 2/5 bagian) --}}
        <div class="relative hidden lg:flex lg:col-span-2 flex-col justify-between overflow-hidden bg-orange-500 p-10">

            <div class="absolute inset-0 bg-gradient-to-br from-orange-500 via-orange-500 to-orange-600"></div>

            <div class="relative flex items-center gap-3">

                <img
                    src="{{ asset('image/logo-nusaroma.png') }}"
                    class="w-10 h-10 object-contain">

                <span class="text-lg font-bold text-white tracking-wide">
                    Nusaroma
                </span>

            </div>

            <div class="relative">

                <span class="inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/10 px-4 py-2 text-xs font-semibold text-white">

                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                    AI BARISTA

                </span>

                <h1 class="mt-6 text-4xl font-extrabold leading-tight text-white">

                    Good Coffee
                    <br>
                    Starts Here.

                </h1>

                <p class="mt-5 max-w-xs text-base leading-7 text-orange-50">

                    Masuk untuk mengelola pesanan, memantau stok, dan
                    menyajikan pengalaman kopi terbaik untuk pelanggan.

                </p>

            </div>

            <p class="relative text-xs text-orange-100">

                &copy; {{ date('Y') }} Nusaroma Coffee. All rights reserved.

            </p>

        </div>

        {{-- RIGHT: Form (lebih besar, 3/5 bagian) --}}
        <div class="lg:col-span-3 flex items-center justify-center px-6 py-12 sm:px-10">

            <div class="w-full max-w-md">

                <div class="mb-8 lg:hidden flex items-center gap-3">

                    <img
                        src="{{ asset('image/logo-nusaroma.png') }}"
                        class="w-10 h-10 object-contain">

                    <span class="text-lg font-bold text-gray-900">
                        Nusaroma
                    </span>

                </div>

                <p class="text-sm uppercase tracking-[0.3em] text-orange-500 font-bold">
                    Pegawai Login
                </p>

                <h2 class="mt-3 text-3xl font-extrabold text-gray-900">
                    Selamat Datang Kembali
                </h2>

                <p class="mt-3 text-gray-500">
                    Masuk dengan akun pegawai untuk mengakses dashboard.
                </p>

                <x-auth-session-status class="mt-6" :status="session('status')" />

                {{-- Login dengan Google --}}
                <a href="{{ route('auth.google') }}" class="mt-8 flex w-full items-center justify-center gap-3 rounded-full border border-gray-300 bg-white px-6 py-4 font-semibold text-gray-700 transition hover:border-orange-500 hover:text-orange-500">

                    <i class="fa-brands fa-google text-orange-500"></i>
                    Masuk dengan Google

                </a>

                <div class="my-8 flex items-center gap-4">
                    <span class="h-px flex-1 bg-gray-200"></span>
                    <span class="text-sm font-medium text-gray-400">atau</span>
                    <span class="h-px flex-1 bg-gray-200"></span>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-5">

                    @csrf

                    {{-- Email --}}
                    <div>

                        <label for="email" class="mb-2 block text-sm font-semibold text-gray-700">
                            Email
                        </label>

                        <div class="relative">

                            <i class="fa-regular fa-envelope absolute left-5 top-1/2 -translate-y-1/2 text-gray-400"></i>

                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="nama@nusaromacoffee.com"
                                class="w-full rounded-full border border-gray-200 py-4 pl-14 pr-5 outline-none transition focus:border-orange-500 focus:ring-4 focus:ring-orange-100">

                        </div>

                        <x-input-error :messages="$errors->get('email')" class="mt-2 ml-2" />

                    </div>

                    {{-- Password --}}
                    <div>

                        <label for="password" class="mb-2 block text-sm font-semibold text-gray-700">
                            Password
                        </label>

                        <div class="relative">

                            <i class="fa-solid fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-gray-400"></i>

                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••"
                                class="w-full rounded-full border border-gray-200 py-4 pl-14 pr-14 outline-none transition focus:border-orange-500 focus:ring-4 focus:ring-orange-100">

                            <button
                                type="button"
                                onclick="togglePassword()"
                                class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-500">

                                <i id="password-icon" class="fa-regular fa-eye"></i>

                            </button>

                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2 ml-2" />

                    </div>

                    {{-- Remember & Forgot --}}
                    <div class="flex items-center justify-between pt-1">

                        <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">

                            <input
                                id="remember_me"
                                type="checkbox"
                                name="remember"
                                class="rounded border-gray-300 text-orange-500 focus:ring-orange-400">

                            <span class="text-sm text-gray-600">Ingat saya</span>

                        </label>

                        @if (Route::has('password.request'))

                            <a href="{{ route('password.request') }}"
                                class="text-sm font-semibold text-orange-500 hover:text-orange-600">

                                Lupa password?

                            </a>

                        @endif

                    </div>

                    {{-- Submit --}}
                    <button
                        type="submit"
                        class="mt-2 w-full rounded-full bg-orange-500 py-4 font-semibold text-white transition hover:bg-orange-600">

                        Masuk

                    </button>

                </form>

                <p class="mt-10 text-center text-sm text-gray-400">

                    Halaman ini khusus untuk pegawai Nusaroma Coffee.
                    <br>
                    Pelanggan tidak perlu login —
                    <a href="{{ route('pelanggan.beranda') }}" class="font-semibold text-orange-500 hover:text-orange-600">
                        pesan langsung di sini
                    </a>.

                </p>

            </div>

        </div>

    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('password-icon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

    </body>
</html>