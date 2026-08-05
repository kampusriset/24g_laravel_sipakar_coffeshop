<div class="sticky top-8">

    <div class="rounded-[28px] border border-gray-200 bg-white p-7 shadow-sm">

        {{-- Header --}}
        <div class="flex items-start justify-between">

            <div>

                <p class="text-xs font-bold uppercase tracking-[0.35em] text-orange-500">
                    CART
                </p>

                <h3 class="mt-2 text-2xl font-bold text-gray-900">
                    Shopping Cart
                </h3>

            </div>

            <button
                onclick="bersihkanKeranjang()"
                class="text-sm text-gray-400 transition hover:text-red-500">

                Clear

            </button>

        </div>



        {{-- Cart Items --}}
        <div
            id="daftar-item"
            class="mt-8 space-y-5 border-b border-gray-100 pb-6">

            <p
                id="kosong-text"
                class="py-10 text-center text-sm text-gray-400">

                Keranjang masih kosong.

            </p>

        </div>



        {{-- Total --}}
        <div class="mt-6 rounded-2xl bg-orange-50 p-5">

            <div class="flex items-center justify-between">

                <span class="text-gray-500">

                    Subtotal

                </span>

                <span
                    id="total-text"
                    class="text-3xl font-extrabold text-orange-600">

                    Rp 0

                </span>

            </div>

        </div>



        {{-- Checkout --}}
        <button
            onclick="lanjutCheckout()"
            class="mt-6 w-full rounded-2xl bg-orange-500 py-4 font-semibold text-white transition hover:bg-orange-600">

            Lanjut ke Checkout →

        </button>



        {{-- Store --}}
        <div class="mt-8 rounded-2xl border border-gray-200 p-5">

            <div class="flex items-center justify-between">

                <h4 class="font-bold text-gray-900">

                    Nusaroma

                </h4>

                <span
                    class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">

                    Open

                </span>

            </div>

            <div class="mt-4 space-y-2 text-sm text-gray-500">

                <p>
                    🕐 08.00 – 22.00
                </p>

                <p>
                    📍 Jl. Kopi Nikmat No.10
                </p>

            </div>

        </div>

    </div>

</div>

<script>

function getCart() {
    return JSON.parse(localStorage.getItem('cart') || '[]');
}

function saveCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
    renderCartPanel();
}

function tambahKeranjang(menuId, nama, harga) {

    let cart = getCart();

    let existing = cart.find(item => item.menu_id === menuId);

    if (existing) {

        existing.jumlah++;

    } else {

        cart.push({
            menu_id: menuId,
            nama: nama,
            harga: harga,
            jumlah: 1
        });

    }

    saveCart(cart);

}

function ubahJumlahCart(index, delta) {

    let cart = getCart();

    cart[index].jumlah += delta;

    if (cart[index].jumlah <= 0) {

        cart.splice(index,1);

    }

    saveCart(cart);

}

function bersihkanKeranjang() {

    localStorage.removeItem('cart');

    renderCartPanel();

}

function renderCartPanel() {

    let cart = getCart();

    let list = document.getElementById('daftar-item');

    let total = 0;

    if(cart.length===0){

        list.innerHTML=`

            <p class="py-10 text-center text-sm text-gray-400">

                Keranjang masih kosong.

            </p>

        `;

    }else{

        list.innerHTML = cart.map((item,i)=>{

            total += item.harga * item.jumlah;

            return `

                <div class="flex items-center justify-between">

                    <div>

                        <h4 class="font-semibold text-gray-900">

                            ${item.nama}

                        </h4>

                        <p class="mt-1 text-sm text-gray-500">

                            Rp ${item.harga.toLocaleString('id-ID')}

                        </p>

                    </div>

                    <div class="flex items-center gap-3">

                        <button

                            onclick="ubahJumlahCart(${i},-1)"

                            class="flex h-8 w-8 items-center justify-center rounded-full border border-gray-300 hover:border-orange-500">

                            -

                        </button>

                        <span class="font-semibold">

                            ${item.jumlah}

                        </span>

                        <button

                            onclick="ubahJumlahCart(${i},1)"

                            class="flex h-8 w-8 items-center justify-center rounded-full border border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white">

                            +

                        </button>

                    </div>

                </div>

            `;

        }).join('');

    }

    document.getElementById('total-text').innerText =
        'Rp ' + total.toLocaleString('id-ID');

}

function lanjutCheckout(){

    let cart=getCart();

    if(cart.length===0){

        alert('Keranjang masih kosong.');

        return;

    }

    window.location.href="{{ route('pelanggan.checkout') }}";

}

renderCartPanel();

</script>