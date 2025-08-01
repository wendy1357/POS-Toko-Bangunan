<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    /**
     * Satu Sale dimiliki oleh satu User.
     */
protected $fillable = [
    'transaction_code', // <-- TAMBAHKAN INI
    'customer_id',
    'user_id',
    'total_amount',
    'amount_paid',
    'change_due',
    'payment_method',
    'payment_status',
    'transaction_date',
];



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Satu Sale dimiliki oleh satu Customer.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Satu Sale memiliki banyak rincian barang (SaleDetail).
     */
    public function details(): HasMany
    {
        return $this->hasMany(SaleDetail::class);
    }
}
