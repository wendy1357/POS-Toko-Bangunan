<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    /**
     * Satu Customer bisa memiliki banyak Sales.
     */
    protected $fillable=[
    'nama',
    'no_hp',
    'alamat'
    ];

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}