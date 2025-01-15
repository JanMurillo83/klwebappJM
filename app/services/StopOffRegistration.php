<?php

namespace App\Services;

use App\Models\StopOff;

class StopOffRegistration
{
    public static function createStopOff($data)
    {
        return StopOff::create([
            'service_id' => $data['service_id'],
            'role' => $data['role'], // 'shipper' o 'consignee'
            'business_directory_id' => $data['business_directory_id'],
            'position' => $data['position'], // Posición en el orden de paradas
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}