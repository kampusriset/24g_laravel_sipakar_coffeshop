<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Struk - #{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Courier New', Courier, monospace;
                font-size: 12px;
                color: #000;
                background: #e5e5e5;
            }

            .struk {
                width: 80mm;
                margin: 20px auto;
                background: #fff;
                padding: 12px;
            }

            .center { text-align: center; }
            .bold { font-weight: bold; }
            .line {
                border-top: 1px dashed #000;
                margin: 8px 0;
            }

            .row {
                display: flex;
                justify-content: space-between;
                gap: 8px;
            }

            .item-name {
                display: block;
            }

            .item-sub {
                display: flex;
                justify-content: space-between;
                color: #333;
            }

            .toolbar {
                width: 80mm;
                margin: 0 auto 12px;
                display: flex;
                gap: 8px;
            }

            .toolbar button {
                flex: 1;
                padding: 10px;
                font-family: inherit;
                font-size: 13px;
                font-weight: bold;
                border: none;
                border-radius: 6px;
                cursor: pointer;
            }

            .btn-print {
                background: #ea580c;
                color: #fff;
            }

            .btn-back {
                background: #e5e5e5;
                color: #333;
            }

            @media print {
                body {
                    background: #fff;
                }

                .toolbar {
                    display: none;
                }

                .struk {
                    margin: 0;
                    width: 100%;
                }
            }
        </style>
    </head>
    <body>

        <div class="toolbar">
            <button class="btn-back" onclick="window.close()">← Tutup</button>
            <button class="btn-print" onclick="window.print()">🖨️ Cetak Struk</button>
        </div>

        <div class="struk">

            <div class="center bold" style="font-size: 15px;">NUSAROMA COFFEE</div>
            <div class="center">Jl. Kopi Nikmat No. 10</div>
            <div class="center">08.00 - 22.00</div>

            <div class="line"></div>

            <div class="row">
                <span>No. Pesanan</span>
                <span class="bold">#{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="row">
                <span>Tanggal</span>
                <span>{{ $transaksi->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="row">
                <span>Pelanggan</span>
                <span>{{ $transaksi->pelanggan->nama }}</span>
            </div>

            <div class="line"></div>

            @foreach($transaksi->detailTransaksi as $d)
                <div style="margin-bottom: 6px;">
                    <span class="item-name">{{ $d->menu->nama ?? '-' }}</span>
                    <div class="item-sub">
                        <span>{{ $d->jumlah }} x {{ number_format($d->harga, 0, ',', '.') }}</span>
                        <span>{{ number_format($d->subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endforeach

            <div class="line"></div>

            <div class="row bold" style="font-size: 14px;">
                <span>TOTAL</span>
                <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
            </div>
            <div class="row" style="margin-top: 4px;">
                <span>Metode Bayar</span>
                <span>{{ strtoupper($transaksi->pembayaran->metode ?? '-') }}</span>
            </div>
            <div class="row">
                <span>Status</span>
                <span>{{ strtoupper(str_replace('_', ' ', $transaksi->status)) }}</span>
            </div>

            <div class="line"></div>

            <div class="center" style="margin-top: 10px;">
                Terima kasih telah berkunjung!
            </div>
            <div class="center">
                Sampai jumpa lagi ☕
            </div>

        </div>

    </body>
</html>