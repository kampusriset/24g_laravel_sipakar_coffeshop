<?php

namespace App\Services;

use App\Models\Transaksi;

class StokService
{
    public function kurangiStok(Transaksi $transaksi): void
    {
        $transaksi->load('detailTransaksi.menu.bahanUsage.stokBahan');

        foreach ($transaksi->detailTransaksi as $detail) {
            $menu = $detail->menu;

            if (!$menu) {
                continue;
            }

            foreach ($menu->bahanUsage as $bahan) {
                $stokBahan = $bahan->stokBahan;

                if (!$stokBahan) {
                    continue;
                }

                $totalTerpakai = $bahan->jumlah_pakai * $detail->jumlah;
                $stokBaru = max(0, $stokBahan->jumlah - $totalTerpakai);

                $stokBahan->update(['jumlah' => $stokBaru]);
            }
        }
    }
}
