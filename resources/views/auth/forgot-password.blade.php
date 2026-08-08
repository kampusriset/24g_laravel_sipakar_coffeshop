<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Lupa Password - Nusaroma</title>

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

            {{-- LEFT: Branding --}}
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

                        <i class="fa-solid fa-shield-halved"></i>
                        KEAMANAN AKUN

                    </span>

                    <h1 class="mt-6 text-4xl font-extrabold leading-tight text-white">

                        Lupa Password,
                        <br>
                        Bukan Masalah.

                    </h1>

                    <p class="mt-5 max-w-xs text-base leading-7 text-orange-50">

                        Masukkan email akun pegawai Anda, kami akan kirimkan
                        tautan untuk membuat password baru.

                    </p>

                </div>

                <p class="relative text-xs text-orange-100">

                    &copy; {{ date('Y') }} Nusaroma Coffee. All rights reserved.

                </p>

            </div>

            {{-- RIGHT: Form --}}
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

                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-orange-500">

                        <i class="fa-solid fa-arrow-left"></i>
                        Kembali ke Login

                    </a>

                    <p class="mt-6 text-sm uppercase tracking-[0.3em] text-orange-500 font-bold">
                        Reset Password
                    </p>

                    <h2 class="mt-3 text-3xl font-extrabold text-gray-900">
                        Lupa Password?
                    </h2>

                    <p class="mt-3 text-gray-500 leading-7">

                        Tidak masalah. Masukkan alamat email Anda dan kami akan
                        mengirimkan tautan untuk membuat password baru.

                    </p>

                    <x-auth-session-status class="mt-6" :status="session('status')" />

                    <form method="POST" action="{{ route('password.email') }}" class="mt-8 space-y-5">

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
                                    placeholder="nama@nusaroma.com"
                                    class="w-full rounded-full border border-gray-200 py-4 pl-14 pr-5 outline-none transition focus:border-orange-500 focus:ring-4 focus:ring-orange-100">

                            </div>

                            <x-input-error :messages="$errors->get('email')" class="mt-2 ml-2" />

                        </div>

                        {{-- Submit --}}
                        <button
                            type="submit"
                            class="mt-2 w-full rounded-full bg-orange-500 py-4 font-semibold text-white transition hover:bg-orange-600">

                            Kirim Link Reset Password

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </body>
</html>