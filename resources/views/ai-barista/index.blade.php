<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Nusaroma | AI Barista</title>

        <script src="https://cdn.tailwindcss.com"></script>

        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    </head>

    <body class="bg-white min-h-screen">

        <div class="flex min-h-screen">

            @include('pelanggan.partials.sidebar')

            <main class="flex-1 ml-64">

                <div class="flex flex-col h-screen">

                    {{-- Header --}}
                    <div class="bg-white border-b border-gray-200 px-10 py-5 flex items-center justify-between">

                        <div>

                            <p class="text-[11px] uppercase tracking-[0.35em] text-orange-500 font-bold">
                                AI ASSISTANT
                            </p>

                            <h1 class="mt-1 text-2xl font-bold text-gray-900">
                                AI Barista
                            </h1>

                            <p class="mt-1 text-sm text-gray-500">
                                Rekomendasi minuman berdasarkan preferensi Anda.
                            </p>

                        </div>

                        <button
                            onclick="location.reload()"
                            class="flex items-center gap-2 rounded-xl border border-orange-300 px-4 py-2 text-sm font-medium text-orange-600 transition hover:bg-orange-50">

                            <i class="fa-solid fa-rotate-right"></i>

                            <span>Mulai Konsultasi Baru</span>

                        </button>

                    </div>

                    <div class="flex-1 flex overflow-hidden bg-gray-50">

                        {{-- CHAT AREA --}}
                        <div class="flex-1 flex flex-col">

                            {{-- Chat --}}
                            <div
                                id="chat-box"
                                class="flex-1 overflow-y-auto px-8 py-6 space-y-5">

                            </div>

                            {{-- Input --}}
                            <div class="border-t border-gray-200 bg-white px-8 py-5">

                                <div class="flex items-center gap-3">

                                    <input
                                        type="text"
                                        id="chat-input"
                                        placeholder="Ketik jawaban atau pilih opsi di atas..."
                                        autocomplete="off"
                                        class="flex-1 rounded-full border border-gray-300 bg-white px-6 py-3.5 text-sm outline-none transition-all focus:border-orange-500 focus:ring-4 focus:ring-orange-100">

                                    <button
                                        onclick="kirimTeks()"
                                        class="flex h-12 w-12 items-center justify-center rounded-full bg-orange-500 text-white transition hover:bg-orange-600">

                                        <i class="fa-solid fa-paper-plane"></i>

                                    </button>

                                </div>

                            </div>

                        </div>

                        {{-- PANEL REKOMENDASI --}}
                        <aside class="w-96 bg-white border-l border-gray-200 flex flex-col">

                            <div class="px-8 py-7 border-b border-gray-200">

                                <p class="text-xs uppercase tracking-[0.35em] text-orange-500 font-bold">
                                    REKOMENDASI
                                </p>

                                <h2 class="mt-2 text-3xl font-bold text-gray-900">
                                    Pilihan Terbaik
                                </h2>

                                <p class="mt-3 text-sm text-gray-500 leading-6">
                                    AI akan menampilkan rekomendasi menu terbaik berdasarkan jawaban Anda.
                                </p>

                            </div>

                            <div id="rekomendasi-box" class="flex-1 overflow-y-auto p-6 space-y-5">

                                {{-- Saat belum ada hasil --}}
                                <div id="empty-state"
                                    class="h-full flex flex-col items-center justify-center text-center">

                                    <div
                                        class="w-24 h-24 rounded-full bg-orange-100 flex items-center justify-center">

                                        <i class="fa-solid fa-mug-hot text-5xl text-orange-500"></i>

                                    </div>

                                    <h3 class="mt-6 text-xl font-bold text-gray-900">
                                        Belum Ada Rekomendasi
                                    </h3>

                                    <p class="mt-3 text-gray-500 leading-7 max-w-xs">

                                        Jawab semua pertanyaan AI Barista terlebih dahulu.

                                    </p>

                                </div>

                            </div>

                        </aside>

                    </div>

                </div>
            </main>

        </div>

        <script>
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const chatBox = document.getElementById('chat-box');
            const chatInput = document.getElementById('chat-input');

            let step = -1; // -1 = tanya nama
            let answers = {};
            let namaPelanggan = '';

            const questions = [
                { key: 'mood', text: 'Bagaimana mood Anda saat ini?', options: [
                    { value: 'Mengantuk', label: '😴 Mengantuk' },
                    { value: 'Butuh Fokus', label: '🎯 Butuh Fokus' },
                    { value: 'Santai', label: '😌 Santai' },
                    { value: 'Stres', label: '😣 Stres' },
                    { value: 'Bahagia', label: '😄 Bahagia' },
                ]},
                { key: 'cuaca', text: 'Bagaimana cuaca saat ini?', options: [
                    { value: 'Panas', label: '☀️ Panas' },
                    { value: 'Hujan', label: '🌧️ Hujan' },
                    { value: 'Normal', label: '⛅ Normal' },
                ]},
                { key: 'waktu', text: 'Kapan Anda ingin menikmati minuman?', options: [
                    { value: 'Pagi', label: '🌅 Pagi' },
                    { value: 'Siang', label: '🌤️ Siang' },
                    { value: 'Malam', label: '🌙 Malam' },
                ]},
                { key: 'jenis_minuman', text: 'Jenis minuman yang Anda inginkan?', options: [
                    { value: 'Coffee', label: '☕ Coffee' },
                    { value: 'Non Coffee', label: '🥤 Non Coffee' },
                ]},
                { key: 'jawaban_susu', text: 'Seberapa suka Anda dengan susu?', options: [
                    { value: 'Sangat Suka', label: 'Sangat Suka' },
                    { value: 'Suka', label: 'Suka' },
                    { value: 'Cukup Suka', label: 'Cukup Suka' },
                    { value: 'Kurang Suka', label: 'Kurang Suka' },
                    { value: 'Tidak Suka', label: 'Tidak Suka' },
                    { value: 'Alergi', label: 'Alergi' },
                ]},
                { key: 'jawaban_kopi', text: 'Seberapa suka Anda dengan rasa kopi?', options: [
                    { value: 'Sangat Suka', label: 'Sangat Suka' },
                    { value: 'Suka', label: 'Suka' },
                    { value: 'Cukup Suka', label: 'Cukup Suka' },
                    { value: 'Kurang Suka', label: 'Kurang Suka' },
                    { value: 'Tidak Suka', label: 'Tidak Suka' },
                ]},
                { key: 'jawaban_manis', text: 'Seberapa suka Anda dengan minuman manis?', options: [
                    { value: 'Sangat Suka', label: 'Sangat Suka' },
                    { value: 'Suka', label: 'Suka' },
                    { value: 'Cukup Suka', label: 'Cukup Suka' },
                    { value: 'Kurang Suka', label: 'Kurang Suka' },
                    { value: 'Tidak Suka', label: 'Tidak Suka' },
                ]},
            ];

            function jam() {
                return new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            }

            function botBubble(html) {
                const div = document.createElement('div');
                div.className = 'flex items-start gap-3';

                div.innerHTML = `
                <div class="w-10 h-10 rounded-full bg-orange-500 text-white flex items-center justify-center shadow-sm shrink-0">
                    🤖
                </div>

                <div class="bg-white border border-gray-200 rounded-3xl rounded-tl-md px-5 py-4 max-w-xl shadow-sm">

                    ${html}

                    <p class="text-[11px] text-gray-400 mt-3 text-right">${jam()}</p>

                </div>
                `;
                chatBox.appendChild(div);
                chatBox.scrollTop = chatBox.scrollHeight;
                return div;
            }

            function userBubble(text) {
                const div = document.createElement('div');
                div.className = 'flex justify-end';

                div.innerHTML = `
                <div class="bg-orange-500 text-white rounded-3xl rounded-br-md px-5 py-4 max-w-md shadow">

                ${text}

                <p class="text-[11px] text-orange-100 mt-2 text-right">

                ${jam()} ✓

                </p>

                </div>
                `;
                chatBox.appendChild(div);
                chatBox.scrollTop = chatBox.scrollHeight;
            }

            function tampilkanOpsi(options, onSelect) {
                const wrap = document.createElement('div');
                wrap.className =
                    'flex flex-wrap gap-3 mt-5';
                options.forEach(opt => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className =
                        'group flex items-center gap-2 rounded-full border border-orange-200 bg-white px-5 py-3 text-sm font-semibold text-gray-700 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:border-orange-500 hover:bg-orange-50 hover:text-orange-600 hover:shadow-md disabled:cursor-not-allowed';
                    btn.innerHTML = `
                        <span>${opt.label}</span>
                    `;
                    btn.onclick = () => {
                        wrap.querySelectorAll('button').forEach(button => {
                            button.disabled = true;
                            button.classList.remove(
                                'bg-white',
                                'border-orange-200',
                                'text-gray-700'
                            );
                            button.classList.add(
                                'opacity-60'
                            );
                        });
                        btn.classList.remove('opacity-60');
                        btn.classList.add(
                            'bg-orange-500',
                            'border-orange-500',
                            'text-white',
                            'shadow-lg',
                            'scale-105'
                        );
                        setTimeout(() => {
                            wrap.remove();
                            onSelect(opt.value, opt.label);
                        }, 350);
                    };
                    wrap.appendChild(btn);
                });
                chatBox
                    .lastElementChild
                    .querySelector('div.bg-white')
                    .appendChild(wrap);
                chatBox.scrollTop = chatBox.scrollHeight;
            }

            function mulai() {
                botBubble('Halo! 👋<br>Saya AI Barista. Saya akan membantu memilih minuman yang paling cocok untuk Anda. Siapa nama Anda?');
            }

            function kirimTeks() {
                const val = chatInput.value.trim();
                if (!val) return;

                if (step === -1) {
                    namaPelanggan = val;
                    userBubble(val);
                    chatInput.value = '';
                    step = 0;
                    setTimeout(tanyaPertanyaan, 400);
                } else {
                    chatInput.value = '';
                }
            }

            chatInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') kirimTeks();
            });

            function tanyaPertanyaan() {
                if (step >= questions.length) {
                    selesaiKonsultasi();
                    return;
                }

                const q = questions[step];
                botBubble(`Pertanyaan ${step + 1} dari ${questions.length}<br><span class="font-semibold">${q.text}</span>`);
                tampilkanOpsi(q.options, (value, label) => {
                    answers[q.key] = value;
                    userBubble(label);
                    step++;
                    setTimeout(tanyaPertanyaan, 400);
                });
            }

            function selesaiKonsultasi() {
                const typing = botBubble('Menghitung rekomendasi terbaik untukmu... ⏳');

                fetch("{{ route('ai-barista.proses') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        nama_pelanggan: namaPelanggan,
                        ...answers,
                    }),
                })
                .then(res => res.json())
                .then(data => {
                    typing.remove();
                    botBubble(`Berikut rekomendasi terbaik untukmu, <strong>${data.pelanggan}</strong>! 🎉`);
                    renderRekomendasi(data.rekomendasi);
                })
                .catch(() => {
                    typing.remove();
                    botBubble('Maaf, terjadi kesalahan. Silakan coba lagi. 🙏');
                });
            }

            function tambahKeranjangDariAi(menuId, nama, harga, gambar, btn) {

                let cart = JSON.parse(localStorage.getItem('cart') || '[]');

                let existing = cart.find(item => item.menu_id === menuId);

                if (existing) {

                    existing.jumlah += 1;

                } else {

                    cart.push({
                        menu_id: menuId,
                        nama: nama,
                        harga: harga,
                        gambar: gambar,
                        jumlah: 1
                    });

                }

                localStorage.setItem('cart', JSON.stringify(cart));

                btn.innerText = 'Ditambahkan';
                btn.disabled = true;
                btn.classList.add('opacity-70');
            }

            function kodeMenu(id) {
                return 'M' + String(id).padStart(2, '0');
            }

            function renderRekomendasi(list) {

                const box = document.getElementById('rekomendasi-box');
                box.innerHTML = '';

                if (list.length === 0) {
                    box.innerHTML = `
                        <div class="h-full flex flex-col items-center justify-center text-center">

                            <div class="w-24 h-24 rounded-full bg-orange-100 flex items-center justify-center">

                                <i class="fa-solid fa-mug-hot text-5xl text-orange-500"></i>

                            </div>

                            <h3 class="mt-6 text-xl font-bold text-gray-900">

                                Belum Ada Rekomendasi

                            </h3>

                            <p class="mt-3 text-gray-500 leading-7 max-w-xs">

                                Jawab semua pertanyaan AI Barista terlebih dahulu.

                            </p>

                        </div>
                    `;
                    return;
                }

                list.forEach(item => {

                    if (item.ranking === 1) {

                        const card = document.createElement('div');

                        card.className =
                            'bg-white border border-orange-200 rounded-[28px] shadow overflow-hidden mb-6';

                        card.innerHTML = `

                            ${
                                item.gambar
                                ? `<img src="${item.gambar}" class="w-full h-52 object-cover">`
                                : `
                                <div class="w-full h-52 bg-orange-50 flex items-center justify-center">

                                    <i class="fa-solid fa-mug-hot text-6xl text-orange-400"></i>

                                </div>`
                            }

                            <div class="p-6">

                                <span class="inline-flex items-center rounded-full bg-orange-100 px-4 py-2 text-xs font-bold text-orange-600">

                                    ⭐ Best Match

                                </span>

                                <h3 class="mt-4 text-2xl font-bold text-gray-900">

                                    ${item.nama}

                                </h3>

                                <p class="text-sm text-gray-500">

                                    ${kodeMenu(item.menu_id)} • ${item.kategori}

                                </p>

                                <div class="mt-5">

                                    <div class="flex justify-between text-sm mb-2">

                                        <span class="text-gray-500">

                                            Tingkat Kecocokan

                                        </span>

                                        <span class="font-bold text-orange-500">

                                            ${item.persentase}%

                                        </span>

                                    </div>

                                    <div class="w-full h-2 rounded-full bg-orange-100 overflow-hidden">

                                        <div
                                            class="h-full bg-orange-500 rounded-full"
                                            style="width:${item.persentase}%">

                                        </div>

                                    </div>

                                </div>

                                <div class="flex flex-wrap gap-2 mt-5">

                                    <span class="bg-orange-50 text-orange-600 text-xs px-3 py-1 rounded-full">

                                        ${item.label_susu}

                                    </span>

                                    <span class="bg-orange-50 text-orange-600 text-xs px-3 py-1 rounded-full">

                                        ${item.label_kopi}

                                    </span>

                                    <span class="bg-orange-50 text-orange-600 text-xs px-3 py-1 rounded-full">

                                        ${item.label_manis}

                                    </span>

                                </div>

                                <div class="mt-6 flex justify-between items-center">

                                    <span class="text-2xl font-extrabold text-orange-500">

                                        Rp ${Number(item.harga).toLocaleString('id-ID')}

                                    </span>

                                    <button

                                        onclick="tambahKeranjangDariAi(${item.menu_id}, '${item.nama}', ${item.harga}, '${item.gambar}', this)"

                                        class="rounded-full bg-orange-500 px-5 py-3 text-sm font-semibold text-white hover:bg-orange-600 transition">

                                        <i class="fa-solid fa-cart-plus"></i>

                                        Tambah

                                    </button>

                                </div>

                            </div>

                        `;

                        box.appendChild(card);

                    } else {

                        const card = document.createElement('div');

                        card.className =
                            'bg-white border border-gray-200 rounded-2xl p-4 mb-4 flex items-center gap-4 hover:shadow-md transition';

                        card.innerHTML = `

                            <div class="w-7 h-7 rounded-full bg-orange-500 text-white text-xs font-bold flex items-center justify-center shrink-0">

                                ${item.ranking}

                            </div>

                            ${
                                item.gambar
                                ? `<img src="${item.gambar}" class="w-16 h-16 rounded-xl object-cover shrink-0">`
                                : `
                                <div class="w-16 h-16 rounded-xl bg-orange-50 flex items-center justify-center shrink-0">

                                    <i class="fa-solid fa-mug-hot text-2xl text-orange-400"></i>

                                </div>`
                            }

                            <div class="flex-1">

                                <h4 class="font-bold text-gray-900">

                                    ${item.nama}

                                </h4>

                                <p class="text-xs text-gray-500">

                                    ${item.kategori}

                                </p>

                                <div class="mt-2 h-2 rounded-full bg-orange-100 overflow-hidden">

                                    <div
                                        class="h-full bg-orange-500 rounded-full"
                                        style="width:${item.persentase}%">

                                    </div>

                                </div>

                                <p class="text-xs text-orange-500 font-semibold mt-1">

                                    ${item.persentase}% cocok

                                </p>

                            </div>

                            <button

                                onclick="tambahKeranjangDariAi(${item.menu_id}, '${item.nama}', ${item.harga}, '${item.gambar}', this)"

                                class="rounded-full bg-orange-500 px-3 py-2 text-white text-xs hover:bg-orange-600 transition">

                                <i class="fa-solid fa-plus"></i>

                            </button>

                        `;

                        box.appendChild(card);

                    }

                });

                const footer = document.createElement('div');

                footer.className = 'mt-6 border-t border-gray-200 pt-5';

                footer.innerHTML = `

                    <a

                        href="{{ route('pelanggan.keranjang') }}"

                        class="block w-full rounded-full bg-orange-500 text-white text-center py-3 font-semibold hover:bg-orange-600 transition">

                        <i class="fa-solid fa-cart-shopping"></i>

                        Lihat Keranjang →

                    </a>

                    <p class="text-xs text-gray-400 text-center leading-5 mt-4">

                        Rekomendasi dihitung menggunakan metode
                        <strong>Forward Chaining</strong> dan
                        <strong>Certainty Factor (CF)</strong>.

                    </p>

                `;

                box.appendChild(footer);

            }

            mulai();
        </script>
    </body>
</html>