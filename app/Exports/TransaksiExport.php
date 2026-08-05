<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransaksiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $dariTanggal;
    protected $sampaiTanggal;

    public function __construct($dariTanggal = null, $sampaiTanggal = null)
    {
        $this->dariTanggal = $dariTanggal;
        $this->sampaiTanggal = $sampaiTanggal;
    }

    public function collection()
    {
        $query = Transaksi::with(['pelanggan', 'user', 'detailTransaksi.menu', 'pembayaran'])
            ->orderBy('created_at', 'desc');

        if ($this->dariTanggal && $this->sampaiTanggal) {
            $query->whereBetween('created_at', [
                $this->dariTanggal . ' 00:00:00',
                $this->sampaiTanggal . ' 23:59:59',
            ]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return ['No', 'Tanggal', 'Pelanggan', 'Diproses Oleh', 'Menu', 'Total', 'Metode Bayar', 'Status Bayar', 'Status Pesanan'];
    }

    public function map($transaksi): array
    {
        static $no = 0;
        $no++;

        $daftarMenu = $transaksi->detailTransaksi->map(function ($d) {
            return ($d->menu->nama ?? '-') . ' x' . $d->jumlah;
        })->implode(', ');

        return [
            $no,
            $transaksi->created_at->format('d-m-Y H:i'),
            $transaksi->pelanggan->nama ?? '-',
            $transaksi->user->name ?? 'Pelanggan (Mandiri)',
            $daftarMenu,
            $transaksi->total_harga,
            ucfirst($transaksi->pembayaran->metode ?? '-'),
            ucfirst($transaksi->pembayaran->status ?? '-'),
            str_replace('_', ' ', ucfirst($transaksi->status)),
        ];
    }
}