<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'services_suppliers', 'id_service_detail', 'supplier_id');
    }
}
