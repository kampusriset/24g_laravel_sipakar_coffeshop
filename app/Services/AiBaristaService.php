<?php

namespace App\Services;

use App\Models\AiJawaban;
use App\Models\AiRekomendasi;
use App\Models\Menu;

class AiBaristaService
{
    public function forwardChaining(string $mood, string $cuaca, string $waktu, string $jenisMinuman): array
    {
        $ruleMood = $jenisMinuman === 'Coffee' ? AiBaristaData::$ruleCoffee : AiBaristaData::$ruleNonCoffee;
        $ruleCuaca = $jenisMinuman === 'Coffee' ? AiBaristaData::$ruleCuacaCoffee : AiBaristaData::$ruleCuacaNonCoffee;
        $ruleWaktu = $jenisMinuman === 'Coffee' ? AiBaristaData::$ruleWaktuCoffee : AiBaristaData::$ruleWaktuNonCoffee;

        $kandidat = [];

        if (isset($ruleMood[$mood])) {
            $kandidat = array_merge($kandidat, $ruleMood[$mood]);
        }
        if (isset($ruleCuaca[$cuaca])) {
            $kandidat = array_merge($kandidat, $ruleCuaca[$cuaca]);
        }
        if (isset($ruleWaktu[$waktu])) {
            $kandidat = array_merge($kandidat, $ruleWaktu[$waktu]);
        }

        $kandidat = array_unique($kandidat);

        if (empty($kandidat)) {
            $kandidat = array_keys($ruleMood);
        }

        return array_values($kandidat);
    }

    public function hitungCertaintyFactor(array $kandidatMenu, float $sukaSusu, float $sukaKopi, float $sukaManis): array
    {
        $hasil = [];

        foreach ($kandidatMenu as $namaMenu) {
            if (!isset(AiBaristaData::$bobotPakar[$namaMenu])) {
                continue;
            }

            $bobot = AiBaristaData::$bobotPakar[$namaMenu];

            $cfSusu = $sukaSusu * $bobot['susu'];
            $cfKopi = $sukaKopi * $bobot['kopi'];
            $cfManis = $sukaManis * $bobot['manis'];

            $cf1 = $cfSusu;
            $cf2 = $cf1 + ($cfKopi * (1 - $cf1));
            $cf3 = $cf2 + ($cfManis * (1 - $cf2));

            $hasil[$namaMenu] = round($cf3, 4);
        }

        arsort($hasil);

        return $hasil;
    }

    private function labelTingkat(float $nilai): string
    {
        if ($nilai >= 0.7) return 'Tinggi';
        if ($nilai >= 0.4) return 'Sedang';
        return 'Rendah';
    }

    public function prosesRekomendasi(
        int $pelangganId,
        string $mood,
        string $cuaca,
        string $waktu,
        string $jenisMinuman,
        string $jawabanSusu,
        string $jawabanKopi,
        string $jawabanManis
    ): array {
        $sukaSusu = AiBaristaData::$nilaiKesukaan[$jawabanSusu] ?? 0;
        $sukaKopi = AiBaristaData::$nilaiKesukaan[$jawabanKopi] ?? 0;
        $sukaManis = AiBaristaData::$nilaiKesukaan[$jawabanManis] ?? 0;

        AiJawaban::create([
            'pelanggan_id' => $pelangganId,
            'mood' => $mood,
            'cuaca' => $cuaca,
            'waktu' => $waktu,
            'jenis_minuman' => $jenisMinuman,
            'suka_susu' => $sukaSusu,
            'suka_kopi' => $sukaKopi,
            'suka_manis' => $sukaManis,
        ]);

        $kandidat = $this->forwardChaining($mood, $cuaca, $waktu, $jenisMinuman);
        $hasilCf = $this->hitungCertaintyFactor($kandidat, $sukaSusu, $sukaKopi, $sukaManis);

        $ranking = 1;
        $rekomendasiFinal = [];

        foreach (array_slice($hasilCf, 0, 3, true) as $namaMenu => $nilaiCf) {
            $menu = Menu::where('nama', $namaMenu)->first();
            if (!$menu) {
                continue;
            }

            $bobot = AiBaristaData::$bobotPakar[$namaMenu];

            AiRekomendasi::create([
                'pelanggan_id' => $pelangganId,
                'menu_id' => $menu->id,
                'nilai_cf' => $nilaiCf,
                'ranking' => $ranking,
            ]);

            $rekomendasiFinal[] = [
                'menu' => $menu,
                'nilai_cf' => $nilaiCf,
                'persentase' => round($nilaiCf * 100, 1),
                'ranking' => $ranking,
                'label_susu' => $this->labelTingkat($bobot['susu']),
                'label_kopi' => $this->labelTingkat($bobot['kopi']),
                'label_manis' => $this->labelTingkat($bobot['manis']),
            ];

            $ranking++;
        }

        return $rekomendasiFinal;
    }
}