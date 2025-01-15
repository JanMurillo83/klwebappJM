<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'exchange_rate',
        'effective_date',
    ];

    protected $casts = [
        'effective_date' => 'date', // Convierte automáticamente a Carbon
    ];
}
