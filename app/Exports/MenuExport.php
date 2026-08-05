<?php

namespace App\Exports;

use App\Models\Menu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MenuExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Menu::with('kategoriMenu')->get();
    }

    public function headings(): array
    {
        return ['No', 'Nama Menu', 'Kategori', 'Harga', 'Status'];
    }

    public function map($menu): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $menu->nama,
            $menu->kategoriMenu->nama ?? '-',
            $menu->harga,
            $menu->status ? 'Tersedia' : 'Tidak Tersedia',
        ];
    }
}