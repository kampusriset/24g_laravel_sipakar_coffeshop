<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>AI Barista - A Coffee</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-50 min-h-screen">
<div class="flex min-h-screen">
<div class="flex-1 ml-64 flex flex-col h-screen">

{{-- Header --}}
<div class="bg-white border-b px-8 py-4 flex justify-between items-center shrink-0">
    <div>
        <h1 class="text-xl font-bold">🤖 AI Barista</h1>
        <p class="text-sm text-gray-500">Konsultasikan preferensi Anda, dan saya akan merekomendasikan minuman terbaik!</p>
    </div>
    <button onclick="location.reload()" class="text-sm border border-amber-700 text-amber-700 px-3 py-2 rounded-lg hover:bg-amber-50">
        ↺ Mulai Konsultasi Baru
    </button>
</div>

<div class="flex-1 flex overflow-hidden">

    {{-- Chat Area --}}
    <div class="flex-1 flex flex-col p-6 overflow-hidden">
        <div id="chat-box" class="flex-1 overflow-y-auto space-y-4 pr-2"></div>
        <div class="mt-4 flex gap-2 shrink-0">
            <input type="text" id="chat-input" placeholder="Ketik jawaban atau pilih opsi di atas..."
                class="flex-1 border rounded-lg px-4 py-3 text-sm" autocomplete="off">
            <button onclick="kirimTeks()" class="bg-amber-800 text-white w-12 h-12 rounded-lg hover:bg-amber-900">➤</button>
        </div>
    </div>

    {{-- Panel Rekomendasi --}}
    <div class="w-96 bg-white border-l p-6 overflow-y-auto shrink-0">
        <h3 class="font-bold text-sm mb-4">REKOMENDASI TERBAIK ✨</h3>
        <div id="rekomendasi-box">
            <div class="text-center text-gray-400 py-16 text-sm">
                <p class="text-4xl mb-2">☕</p>
                Jawab semua pertanyaan untuk melihat rekomendasi di sini.
            </div>
        </div>
    </div>

</div>
</div>
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
    div.className = 'flex gap-3 items-start';
    div.innerHTML = `
        <div class="w-9 h-9 rounded-full bg-amber-800 text-white flex items-center justify-center text-lg shrink-0">🤖</div>
        <div class="bg-white border rounded-2xl rounded-tl-none p-4 max-w-md shadow-sm">
            ${html}
            <p class="text-[10px] text-gray-400 mt-2 text-right">${jam()}</p>
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
        <div class="bg-amber-900 text-white rounded-2xl rounded-tr-none px-4 py-3 max-w-md">
            ${text}
            <p class="text-[10px] text-amber-200 mt-1 text-right">${jam()} ✓</p>
        </div>
    `;
    chatBox.appendChild(div);
    chatBox.scrollTop = chatBox.scrollHeight;
}

function tampilkanOpsi(options, onSelect) {
    const wrap = document.createElement('div');
    wrap.className = 'flex flex-wrap gap-2 mt-3';
    options.forEach(opt => {
        const btn = document.createElement('button');
        btn.className = 'border border-amber-300 text-sm px-4 py-2 rounded-full hover:bg-amber-800 hover:text-white hover:border-amber-800 transition';
        btn.innerText = opt.label;
        btn.onclick = () => {
            wrap.querySelectorAll('button').forEach(b => b.disabled = true);
            wrap.remove();
            onSelect(opt.value, opt.label);
        };
        wrap.appendChild(btn);
    });
    chatBox.lastElementChild.querySelector('div.bg-white').appendChild(wrap);
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

function tambahKeranjangDariAi(menuId, nama, harga, btn) {
    let cart = JSON.parse(localStorage.getItem('cart') || '[]');
    let existing = cart.find(item => item.menu_id === menuId);
    if (existing) {
        existing.jumlah += 1;
    } else {
        cart.push({ menu_id: menuId, nama: nama, harga: harga, jumlah: 1 });
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    btn.innerText = '✔ Ditambahkan';
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
        box.innerHTML = '<p class="text-center text-gray-400 text-sm py-10">Belum ada rekomendasi yang cocok.</p>';
        return;
    }

    list.forEach(item => {
        if (item.ranking === 1) {
            const card = document.createElement('div');
            card.className = 'bg-amber-900 text-white rounded-xl p-4 mb-4 ring-2 ring-amber-500';
            card.innerHTML = `
                <div class="flex items-center gap-2 mb-2">
                    <span class="bg-amber-500 text-amber-900 text-xs font-bold w-6 h-6 rounded-full flex items-center justify-center">1</span>
                </div>
                ${item.gambar ? `<img src="${item.gambar}" class="w-full h-32 object-cover rounded-lg mb-3">` : `<div class="w-full h-32 bg-amber-800 rounded-lg mb-3 flex items-center justify-center text-4xl">☕</div>`}
                <div class="flex justify-between items-start mb-1">
                    <div>
                        <p class="text-lg font-bold">${item.nama}</p>
                        <p class="text-xs text-amber-200">${kodeMenu(item.menu_id)} • ${item.kategori}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xl font-bold">${item.persentase}%</p>
                        <p class="text-[10px] text-amber-200">Tingkat Kecocokan</p>
                    </div>
                </div>
                <p class="text-xs text-amber-100 mt-2 mb-3">Sangat cocok untuk mood dan kondisi Anda saat ini.</p>
                <div class="flex flex-wrap gap-1 mb-3">
                    <span class="bg-amber-800 text-[10px] px-2 py-1 rounded-full">Susu: ${item.label_susu}</span>
                    <span class="bg-amber-800 text-[10px] px-2 py-1 rounded-full">Kopi: ${item.label_kopi}</span>
                    <span class="bg-amber-800 text-[10px] px-2 py-1 rounded-full">Manis: ${item.label_manis}</span>
                </div>
                <button onclick="tambahKeranjangDariAi(${item.menu_id}, '${item.nama}', ${item.harga}, this)"
                    class="w-full bg-white text-amber-900 font-semibold text-sm py-2.5 rounded-lg hover:bg-amber-50">
                    🛒 Tambahkan ke Keranjang
                </button>
            `;
            box.appendChild(card);
        } else {
            const card = document.createElement('div');
            card.className = 'bg-white border rounded-xl p-3 mb-3 flex gap-3 items-center';
            card.innerHTML = `
                <span class="bg-gray-800 text-white text-xs font-bold w-6 h-6 rounded-full flex items-center justify-center shrink-0">${item.ranking}</span>
                ${item.gambar ? `<img src="${item.gambar}" class="w-14 h-14 object-cover rounded-lg shrink-0">` : `<div class="w-14 h-14 bg-amber-50 rounded-lg flex items-center justify-center text-xl shrink-0">☕</div>`}
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-sm truncate">${item.nama}</p>
                    <p class="text-xs text-gray-400">${kodeMenu(item.menu_id)} • ${item.kategori}</p>
                    <div class="flex flex-wrap gap-1 mt-1">
                        <span class="bg-gray-100 text-[9px] px-1.5 py-0.5 rounded-full text-gray-600">Susu: ${item.label_susu}</span>
                        <span class="bg-gray-100 text-[9px] px-1.5 py-0.5 rounded-full text-gray-600">Kopi: ${item.label_kopi}</span>
                    </div>
                </div>
                <div class="text-right shrink-0">
                    <p class="font-bold text-amber-700">${item.persentase}%</p>
                    <button onclick="tambahKeranjangDariAi(${item.menu_id}, '${item.nama}', ${item.harga}, this)"
                        class="text-[10px] bg-amber-800 text-white px-2 py-1 rounded mt-1 hover:bg-amber-900">+ Keranjang</button>
                </div>
            `;
            box.appendChild(card);
        }
    });

    const linkKeranjang = document.createElement('a');
    linkKeranjang.href = "#";
    linkKeranjang.className = 'block text-center text-sm text-amber-700 font-medium mt-2';
    linkKeranjang.innerText = 'Lihat Keranjang →';
    box.appendChild(linkKeranjang);

    const note = document.createElement('p');
    note.className = 'text-[11px] text-gray-400 text-center mt-4';
    note.innerText = 'Rekomendasi ini dihitung menggunakan Metode Forward Chaining & Certainty Factor (CF)';
    box.appendChild(note);
}

mulai();
</script>
</body>
</html>