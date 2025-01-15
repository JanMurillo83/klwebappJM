<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uom extends Model
{
    use HasFactory;

    protected $table = 'uoms';

    // Campos que pueden ser asignados en masa
    protected $fillable = [
        'name',
        'description',
    ];

    // Ejemplo de relación con otro modelo (si aplica)
    // Modality usa uom como relación
    public function modalities()
    {
        return $this->hasMany(Modality::class, 'uom');
    }

    // Relación con Cargo para peso
    public function cargoWeights()
    {
        return $this->hasMany(Cargo::class, 'uom_weight');
    }

    // Relación con Cargo para dimensiones
    public function cargoDimensions()
    {
        return $this->hasMany(Cargo::class, 'uom_dimensions');
    }
}
