<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $table = 'cargo';

    protected $fillable = [
        'handling_type',
        'material_type',
        'class',
        'count',
        'stackable',
        'weight',
        'uom_weight',
        'length',
        'width',
        'height',
        'uom_dimensions',
        'total_yards',
    ];

    // Relación con Handling Type
    public function handlingType()
    {
        return $this->belongsTo(HandlingType::class, 'handling_type');
    }

    // Relación con Material Type
    public function materialType()
    {
        return $this->belongsTo(MaterialType::class, 'material_type');
    }

    // Relación con Freight Class
    public function freightClass()
    {
        return $this->belongsTo(FreightClass::class, 'class');
    }

    // Relación con UOM para peso
    public function weightUom()
    {
        return $this->belongsTo(Uom::class, 'uom_weight');
    }

    // Relación con UOM para dimensiones
    public function dimensionsUom()
    {
        return $this->belongsTo(Uom::class, 'uom_dimensions');
    }
}
