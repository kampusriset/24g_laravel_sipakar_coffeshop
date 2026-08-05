<aside class="fixed left-0 top-0 h-screen w-64 bg-white border-r border-gray-200 flex flex-col">

    {{-- Logo --}}
    <div class="h-24 flex items-center px-8 border-b border-gray-200">

        <img
            src="{{ asset('image/logo-nusaroma.png') }}"
            class="w-11 h-11 object-contain">

        <div class="ml-3">

            <h1 class="text-lg font-bold tracking-wide text-gray-900">
                Nusaroma
            </h1>
            </p>

        </div>

    </div>

    {{-- Menu --}}
    <nav class="flex-1 px-5 py-8 space-y-2">

        <a href="{{ route('pelanggan.beranda') }}"
        class="group flex items-center gap-4 rounded-xl px-4 py-3 transition-all duration-300
        {{ request()->routeIs('pelanggan.beranda')
            ? 'bg-gray-100 text-orange-500'
            : 'text-gray-500 hover:bg-gray-50 hover:text-orange-500' }}">

            <i class="fa-solid fa-house w-5 text-center"></i>

            <span class="font-medium">
                Beranda
            </span>

        </a>

        <a href="{{ route('pelanggan.menu') }}"
        class="group flex items-center gap-4 rounded-xl px-4 py-3 transition-all duration-300
        {{ request()->routeIs('pelanggan.menu')
            ? 'bg-gray-100 text-orange-500'
            : 'text-gray-500 hover:bg-gray-50 hover:text-orange-500' }}">

            <i class="fa-solid fa-mug-hot w-5 text-center"></i>

            <span class="font-medium">
                Menu
            </span>

        </a>

        <a href="{{ route('ai-barista.index') }}"
        class="group flex items-center justify-between rounded-xl px-4 py-3 transition-all duration-300
        {{ request()->routeIs('ai-barista.*')
            ? 'bg-gray-100 text-orange-500'
            : 'text-gray-500 hover:bg-gray-50 hover:text-orange-500' }}">

            <span class="flex items-center gap-4">

                <i class="fa-solid fa-wand-magic-sparkles w-5 text-center"></i>

                <span class="font-medium">
                    AI Barista
                </span>

            </span>

            @unless(request()->routeIs('ai-barista.*'))

            <span
                class="rounded-full bg-orange-100 px-2 py-1 text-[10px] font-semibold uppercase text-orange-600">

                New

            </span>

            @endunless

        </a>

        <div class="my-6 border-t border-gray-200"></div>

        

    </nav>

    {{-- Bottom --}}
    <div class="p-5 border-t border-gray-200">

        <div class="rounded-2xl border border-orange-200 bg-orange-50 p-4">

            <p class="font-semibold text-gray-900">

                Rewards

            </p>

            <p class="mt-2 text-sm leading-6 text-gray-500">

                Kumpulkan poin dari setiap pembelian dan tukarkan dengan minuman favorit.

            </p>

        </div>

    </div>

</aside>