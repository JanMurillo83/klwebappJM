<?php

namespace App\Services;

use App\Models\Shipper;

class ShipperRegistration
{
    public static function createShipper($data)
    {
        return Shipper::create([
            'service_id' => $data['service_id'],
            'requested_pickup_date' => $data['requested_pickup_date'],
            'time' => $data['time'],
            'scheduled_border_crossing_date' => $data['scheduled_border_crossing_date'],
            'drop_reception_date' => $data['drop_reception_date'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}