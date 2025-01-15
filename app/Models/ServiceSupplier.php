<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSupplier extends Model
{
    use HasFactory;

    protected $table = 'services_suppliers';

    protected $fillable = ['supplier_id', 'id_service_detail'];

    // Relación con Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Relación con ServiceDetail
    public function serviceDetail()
    {
        return $this->belongsTo(ServiceDetail::class, 'id_service_detail');
    }
}
