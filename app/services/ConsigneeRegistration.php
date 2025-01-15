<?php

namespace App\Services;

use App\Models\Consignee;

class ConsigneeRegistration
{
    public static function createConsignee($data)
    {
        return Consignee::create([
            'service_id' => $data['service_id'],
            'delivery_date_requested' => $data['delivery_date_requested'],
            'delivery_time_requested' => $data['delivery_time_requested'], // Valor por defecto si está vacío
            'actual_delivery_date' => $data['actual_delivery_date'],
            'actual_time' => $data['actual_time'], // Valor por defecto si está vacío
            'withdrawal_date' => $data['withdrawal_date'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}