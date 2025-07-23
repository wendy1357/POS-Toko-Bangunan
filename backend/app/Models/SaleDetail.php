<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleDetail extends Model
{
    use HasFactory;

    /**
     * Satu SaleDetail dimiliki oleh satu Sale.
     */
protected $fillable = [
        'sale_id',
        'product_unit_id',
        'quantity',
        'price_per_unit',
        'subtotal'
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Satu SaleDetail merujuk pada satu ProductUnit.
     */
    public function productUnit(): BelongsTo
    {
        return $this->belongsTo(ProductUnit::class);
    }
}
