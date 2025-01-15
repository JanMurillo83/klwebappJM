<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'directory_entry_id',
        'mc_number',
        'usdot',
        'scac',
        'caat',
    ];

    // Relación con la tabla BusinessDirectory
    public function directory()
    {
        return $this->belongsTo(BusinessDirectory::class, 'directory_entry_id');
    }

    // Relación con servicios
    public function services()
    {
        return $this->belongsToMany(ServiceDetail::class, 'services_suppliers', 'supplier_id', 'id_service_detail');
    }

    // Relación con equipos
    public function equipments()
    {
        return $this->hasMany(SupplierEquipment::class);
    }

    // Relación con reseñas
    public function reviews()
    {
        return $this->hasMany(SupplierReview::class);
    }
    public function tarifario()
    {
        return $this->hasMany(Tarifario::class);
    }
}
