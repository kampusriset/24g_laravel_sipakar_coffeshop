<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            Filter Rentang Tanggal
        </x-slot>
        <x-slot name="description">
            Pilih tanggal untuk memfilter laporan, atau kosongkan untuk mengunduh semua data. Klik tombol unduh di pojok kanan atas.
        </x-slot>
        {{ $this->form }}
    </x-filament::section>
</x-filament-panels::page>