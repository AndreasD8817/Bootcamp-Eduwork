<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
        [
            'product_category_id' => 1,
            'name' => 'Samsung S25 Ultra',
            'description' => 'Smartphone',
            'image' => 'https://gizmologi.id/wp-content/uploads/2025/01/Samsung-Galaxy-S25-Ultra-303.jpeg',
            'price' => '25000000',
            'stock' => '25',
        ],[
            'product_category_id' => 2,
            'name' => 'Buku Belajar Laravel',
            'description' => 'Buku Pintar Laravel',
            'image' => 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full/catalog-image/88/MTA-161182132/asfa-solution_buku-panduan-praktis-dan-jitu-menguasai-framework-laravel-6_full01.jpg',
            'price' => '10000',
            'stock' => '250',
        ],[
            'product_category_id' => 3,
            'name' => 'Meja Gaming Asus',
            'description' => 'Meja Gaming Khusus Sultan',
            'image' => 'https://hybrid.co.id/wp-content/uploads/2018/09/5f7f14d368f980bf443f402ded4b1eb8_acer-predator-thronos-01.jpg',
            'price' => '10000000',
            'stock' => '15',
        ],[
            'product_category_id' => 3,
            'name' => 'Meja Gaming Andara',
            'description' => 'Meja Gaming Khusus Sultan',
            'image' => 'https://imgsrv2.voi.id/u_N3rs1X34E24KM6Oe4aiU8IgZV3dqG25j1dThd0nGA/auto/1280/853/sm/1/bG9jYWw6Ly8vcHVibGlzaGVycy8xMzkxMi8yMDIwMDkxNTAwNDktbWFpbi5qcGc.jpg',
            'price' => '100000000',
            'stock' => '150',
        ]
        
        ]);
    }
}
