<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StopOff extends Model
{
    use HasFactory;

    // Especificar la tabla asociada al modelo (opcional si sigue la convención)
    protected $table = 'stop_offs';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'service_id',
        'role', // ENUM('shipper', 'consignee')
        'business_directory_id',
        'position',
    ];

    /**
     * Relación con el modelo `Service`.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Relación con el modelo `BusinessDirectory`.
     */
    public function businessDirectory()
    {
        return $this->belongsTo(BusinessDirectory::class);
    }
}
