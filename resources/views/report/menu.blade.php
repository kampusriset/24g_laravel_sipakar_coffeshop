<h2 align="center">Laporan Data Menu</h2>
<table border="1" width="100%" cellpadding="5" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Nama Menu</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Status</th>
    </tr>
    @foreach($menu as $m)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $m->nama }}</td>
            <td>{{ $m->kategoriMenu->nama ?? '-' }}</td>
            <td>Rp {{ number_format($m->harga, 0, ',', '.') }}</td>
            <td>{{ $m->status ? 'Tersedia' : 'Tidak Tersedia' }}</td>
        </tr>
    @endforeach
</table>