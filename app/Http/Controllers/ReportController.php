<?php

namespace App\Http\Controllers;

use App\Exports\MenuExport;
use App\Exports\TransaksiExport;
use App\Models\Menu;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function menuExcel()
    {
        return Excel::download(new MenuExport, 'laporan-menu.xlsx');
    }

    public function menuPdf()
    {
        $menu = Menu::with('kategoriMenu')->get();

        $pdf = Pdf::loadView('report.menu', [
            'menu' => $menu,
        ]);

        return $pdf->download('laporan-menu.pdf');
    }

    public function transaksiExcel(Request $request)
    {
        return Excel::download(
            new TransaksiExport($request->dari, $request->sampai),
            'laporan-transaksi.xlsx'
        );
    }

    public function transaksiPdf(Request $request)
    {
        $query = Transaksi::with(['pelanggan', 'user', 'detailTransaksi.menu', 'pembayaran'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('dari') && $request->filled('sampai')) {
            $query->whereBetween('created_at', [
                $request->dari . ' 00:00:00',
                $request->sampai . ' 23:59:59',
            ]);
        }

        $transaksi = $query->get();
        $totalPendapatan = $transaksi->where('status', 'selesai')->sum('total_harga');

        $pdf = Pdf::loadView('report.transaksi', [
            'transaksi' => $transaksi,
            'totalPendapatan' => $totalPendapatan,
            'dari' => $request->dari,
            'sampai' => $request->sampai,
        ]);

        return $pdf->download('laporan-transaksi.pdf');
    }
}