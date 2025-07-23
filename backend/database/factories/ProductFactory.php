<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product; // <-- Import Product
use App\Models\ProductUnit; // <-- Import ProductUnit
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama_produk' => fake()->words(3, true),
            'stock_in_base_unit' => fake()->randomFloat(2, 10, 500),
            'base_unit' => 'Pcs',
            'harga_beli_per_base_unit' => fake()->numberBetween(10000, 50000),
            'category_id' => Category::factory(),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            // Membuat satu ProductUnit default untuk setiap produk
            ProductUnit::factory()->create([
                'product_id' => $product->id,
                'unit_name' => 'Pcs',
                'conversion_rate' => 1,
                // Contoh harga jual: 20% lebih tinggi dari harga beli
                'harga_jual' => $product->harga_beli_per_base_unit * 1.2,
            ]);
        });
    }
}