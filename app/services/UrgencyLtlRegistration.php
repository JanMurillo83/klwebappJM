<?php

namespace App\Services;

use App\Models\UrgencyLtl;
use Illuminate\Support\Facades\Log;

class UrgencyLtlRegistration
{
    public static function createUrgencyLtl($data)
    {
        return UrgencyLtl::create([
            'type' => $data['type'],
            'emergency_company' => $data['emergency_company'],
            'company_ID' => $data['company_ID'],
            'phone' => $data['phone'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info('Created UrgencyLtl', ['urgencyLtl' => $urgencyLtl]);

        return $urgencyLtl;
    }
}