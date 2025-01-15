<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactoryCompany extends Model
{
    use HasFactory;
    // Nombre de la tabla (opcional si sigue la convención de nombres Laravel)
    protected $table = 'factory_companies';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'name',      // Nombre de la compañía
        'notes',     // Notas opcionales
    ];
}
