<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentStatus extends Model
{
    use HasFactory;
    
    // Indica si el modelo debe ser timestamped
    public $timestamps = false;

    // Define la tabla asociada con el modelo
    protected $table = 'shipment_status';

    // Define los campos que se pueden asignar masivamente
    protected $fillable = [
        'name',
        'description',
    ];

    // Define los tipos de datos de los campos para la conversión automática
    protected $casts = [
        'id' => 'integer',
    ];
}
