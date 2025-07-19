<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('nama_produk');
        $table->string('sku')->nullable();
        $table->decimal('stock_in_base_unit', 10, 2);
        $table->string('base_unit');
        $table->decimal('harga_beli_per_base_unit', 15, 2);
        $table->foreignId('category_id')->constrained('categories'); // Ini cara membuat Foreign Key
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
