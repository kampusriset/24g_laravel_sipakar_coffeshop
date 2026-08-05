<h2 align="center">Laporan Data Transaksi</h2>

@if($dari && $sampai)
    <p align="center">Periode: {{ \Carbon\Carbon::parse($dari)->format('d M Y') }} - {{ \Carbon\Carbon::parse($sampai)->format('d M Y') }}</p>
@endif

<table border="1" width="100%" cellpadding="5" cellspacing="0" style="font-size: 11px;">
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Pelanggan</th>
        <th>Menu</th>
        <th>Total</th>
        <th>Metode</th>
        <th>Status</th>
    </tr>
    @foreach($transaksi as $t)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $t->created_at->format('d-m-Y H:i') }}</td>
            <td>{{ $t->pelanggan->nama ?? '-' }}</td>
            <td>
                @foreach($t->detailTransaksi as $d)
                    {{ $d->menu->nama ?? '-' }} x{{ $d->jumlah }}@if(!$loop->last), @endif
                @endforeach
            </td>
            <td>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
            <td>{{ ucfirst($t->pembayaran->metode ?? '-') }}</td>
            <td>{{ str_replace('_', ' ', ucfirst($t->status)) }}</td>
        </tr>
    @endforeach
</table>

<br>
<table width="100%">
    <tr>
        <td align="right"><strong>Total Pendapatan (Selesai): Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</strong></td>
    </tr>
</table>