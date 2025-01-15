<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipper extends Model
{
    use HasFactory;

    // Definir la tabla asociada al modelo
    protected $table = 'shippers';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'service_id',
        'requested_pickup_date',
        'time',
        'scheduled_border_crossing_date',
        'drop_reception_date',
    ];

    /**
     * Relación con la tabla `services`.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
