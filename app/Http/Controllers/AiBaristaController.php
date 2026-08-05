<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Services\AiBaristaService;
use Illuminate\Http\Request;

class AiBaristaController extends Controller
{
    public function index()
    {
        return view('ai-barista.index');
    }

    public function proses(Request $request, AiBaristaService $service)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'mood' => 'required|string',
            'cuaca' => 'required|string',
            'waktu' => 'required|string',
            'jenis_minuman' => 'required|string',
            'jawaban_susu' => 'required|string',
            'jawaban_kopi' => 'required|string',
            'jawaban_manis' => 'required|string',
        ]);

        $pelanggan = Pelanggan::create([
            'nama' => $request->nama_pelanggan,
        ]);

        $rekomendasi = $service->prosesRekomendasi(
            $pelanggan->id,
            $request->mood,
            $request->cuaca,
            $request->waktu,
            $request->jenis_minuman,
            $request->jawaban_susu,
            $request->jawaban_kopi,
            $request->jawaban_manis
        );

        $data = collect($rekomendasi)->map(function ($item) {
            return [
                'menu_id' => $item['menu']->id,
                'nama' => $item['menu']->nama,
                'harga' => $item['menu']->harga,
                'gambar' => $item['menu']->gambar ? asset('storage/' . $item['menu']->gambar) : null,
                'kategori' => $item['menu']->kategoriMenu->nama ?? '-',
                'persentase' => $item['persentase'],
                'ranking' => $item['ranking'],
                'label_susu' => $item['label_susu'],
                'label_kopi' => $item['label_kopi'],
                'label_manis' => $item['label_manis'],
            ];
        });

        return response()->json([
            'pelanggan' => $pelanggan->nama,
            'rekomendasi' => $data,
        ]);
    }
}