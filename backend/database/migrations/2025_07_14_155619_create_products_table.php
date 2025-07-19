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
        $table->string('name');
        $table->string('sku')->unique()->nullable(); // SKU bisa unik atau dikosongi
        $table->decimal('purchase_price', 15, 2); // Harga Beli
        $table->decimal('selling_price', 15, 2);  // Harga Jual
        $table->string('unit'); // Satuan: sak, batang, buah, dll
        $table->integer('stock')->default(0);
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
