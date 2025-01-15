<?php

namespace App\Services;

use App\Models\Cargo;

class CargoRegistration
{
    public static function createCargo($data)
    {
        return Cargo::create([
            'handling_type' => $data['handling_type'],
            'material_type' => $data['material_type'],
            'class' => $data['freight_class'],
            'count' => $data['count'],
            'stackable' => $data['stackable'],
            'weight' => $data['weight'],
            'uom_weight' => $data['uom_weight'],
            'length' => $data['length'],
            'width' => $data['width'],
            'height' => $data['height'],
            'uom_dimensions' => $data['uom_dimensions'],
            'total_yards' => $data['total_yards'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}