<?php

namespace App\Services;

class AiBaristaData
{
    public static array $ruleCoffee = [
        'Mengantuk' => ['Espresso', 'Americano'],
        'Butuh Fokus' => ['Espresso', 'Americano'],
        'Santai' => ['Cappuccino', 'Caramel Macchiato'],
        'Stres' => ['Kopi Gula Aren', 'Cafe Latte'],
        'Bahagia' => ['Caramel Macchiato', 'Kopi Gula Aren'],
    ];

    public static array $ruleNonCoffee = [
        'Mengantuk' => ['Chocolate', 'Matcha Latte'],
        'Butuh Fokus' => ['Lemon Tea', 'Matcha Latte'],
        'Santai' => ['Matcha Latte', 'Taro Latte'],
        'Stres' => ['Chocolate', 'Taro Latte'],
        'Bahagia' => ['Red Velvet', 'Matcha Latte'],
    ];

    public static array $ruleCuacaCoffee = [
        'Hujan' => ['Cappuccino', 'Mocha'],
        'Panas' => ['Americano'],
        'Normal' => ['Cafe Latte', 'Caramel Macchiato'],
    ];

    public static array $ruleCuacaNonCoffee = [
        'Panas' => ['Lemon Tea'],
        'Hujan' => ['Chocolate'],
        'Normal' => ['Red Velvet'],
    ];

    public static array $ruleWaktuCoffee = [
        'Pagi' => ['Espresso'],
        'Siang' => ['Cafe Latte'],
        'Malam' => ['Mocha'],
    ];

    public static array $ruleWaktuNonCoffee = [
        'Pagi' => ['Lemon Tea'],
        'Siang' => ['Taro Latte'],
        'Malam' => ['Chocolate'],
    ];

    public static array $bobotPakar = [
        'Espresso' => ['susu' => 0.00, 'kopi' => 0.95, 'manis' => 0.10],
        'Americano' => ['susu' => 0.00, 'kopi' => 0.90, 'manis' => 0.10],
        'Cappuccino' => ['susu' => 0.90, 'kopi' => 0.80, 'manis' => 0.60],
        'Cafe Latte' => ['susu' => 0.95, 'kopi' => 0.60, 'manis' => 0.70],
        'Kopi Gula Aren' => ['susu' => 0.80, 'kopi' => 0.70, 'manis' => 0.95],
        'Mocha' => ['susu' => 0.90, 'kopi' => 0.70, 'manis' => 0.90],
        'Caramel Macchiato' => ['susu' => 0.95, 'kopi' => 0.60, 'manis' => 0.95],
        'Matcha Latte' => ['susu' => 0.90, 'kopi' => 0.00, 'manis' => 0.70],
        'Chocolate' => ['susu' => 0.95, 'kopi' => 0.00, 'manis' => 0.90],
        'Red Velvet' => ['susu' => 0.95, 'kopi' => 0.00, 'manis' => 0.85],
        'Taro Latte' => ['susu' => 0.95, 'kopi' => 0.00, 'manis' => 0.80],
        'Lemon Tea' => ['susu' => 0.00, 'kopi' => 0.00, 'manis' => 0.50],
    ];

    public static array $nilaiKesukaan = [
        'Sangat Suka' => 1.0,
        'Suka' => 0.8,
        'Cukup Suka' => 0.6,
        'Kurang Suka' => 0.4,
        'Tidak Suka' => 0.2,
        'Alergi' => 0.0,
    ];
}