<?php

namespace App\Services;

use App\Models\Service;
use App\Models\ExchangeRate;

//Este servicio se encargará de registrar un nuevo servicio en la tabla services.

class ServiceRegistration
{

    
    public static function createService($data)
    {
        $latestExchangeRate = ExchangeRate::latest('effective_date')->first();

        return Service::create([
            'exchange_rate_id' => $latestExchangeRate->id ?? null,
            'user_id' => $data['user_id'],
            'business_directory_id' => $data['customer'],
            'shipment_status' => $data['shipment_status'],
            'id_service_detail' => $data['service_detail_id'],
            'cargo_id' => $data['cargo_id'], // Asignar el ID del cargo creado
            'urgency_ltl_id' => $data['urgency_ltl_id'], // Asignar el ID del UrgencyLtl
            'rate_to_customer' => $data['rate_to_customer'],
            'currency' => $data['currency'],
            'billing_customer_reference' => $data['billing_currency_reference'],
            'pickup_number' => $data['pickup_number'],
            'expedited' => $data['expedited'],
            'hazmat' => $data['hazmat'],
            'team_driver' => $data['team_driver'],
            'round_trip' => $data['round_trip'],
            'un_number' => $data['un_number'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
