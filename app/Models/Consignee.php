<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consignee extends Model
{
    use HasFactory;

    // Define la tabla asociada al modelo (opcional si sigue la convención)
    protected $table = 'consignees';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'service_id',
        'delivery_date_requested',
        'delivery_time_requested',
        'actual_delivery_date',
        'actual_time',
        'withdrawal_date',
    ];

    /**
     * Relación con la tabla `services`.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
