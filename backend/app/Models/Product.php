<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
        use HasFactory;

    // Relasi ke Category (Satu Produk hanya punya satu Kategori)
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke ProductUnit (Satu Produk punya banyak Satuan Jual)
    public function units(): HasMany
    {
        return $this->hasMany(ProductUnit::class);
    }
}
