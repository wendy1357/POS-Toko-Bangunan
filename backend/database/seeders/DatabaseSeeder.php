<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat 1 User utama
        User::factory()->create([
            'name' => 'Admin Owner',
            'email' => 'wendywicaksana@gmail.com',
        ]);

        // Membuat 10 Kategori
        Category::factory(10)->create();

        // Membuat 50 Produk
        Product::factory(50)->create();

        // Anda bisa tambahkan factory lain di sini nanti...
        // \App\Models\Customer::factory(20)->create();
    }
}
