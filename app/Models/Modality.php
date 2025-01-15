<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modality extends Model
{
    use HasFactory;

    protected $table = 'modality';

    protected $fillable = [
        'type',
        'container',
        'size',
        'weight',
        'uom',
        'material_type',
    ];

    // Relación con UOM (Unidad de Medida)
    public function uom()
    {
        return $this->belongsTo(Uom::class, 'uom');
    }

    // Relación con Material Type
    public function materialType()
    {
        return $this->belongsTo(MaterialType::class, 'material_type');
    }
}
