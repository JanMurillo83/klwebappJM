<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ShipmentStatus;
use App\Models\ServiceDetail;
use App\Models\UrgencyLtl;
use App\Models\Modality;
use App\Models\Cargo;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'exchange_rate_id',
        'user_id',
        'business_directory_id',
        'shipment_status',
        'id_service_detail',
        'urgency_ltl_id',
        'modality_id',
        'cargo_id',
        'rate_to_customer',
        'currency',
        'billing_customer_reference',
        'pickup_number',
        'expedited',
        'hazmat',
        'team_driver',
        'round_trip',
        'un_number',
        'manual_status',
        'time_status',
        'eta_delivery_status',
        'notes_status',
        'sub_services',
    ];

    // Relaciones
    public function exchangeRate()
    {
        return $this->belongsTo(ExchangeRate::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function businessDirectory()
    {
        return $this->belongsTo(BusinessDirectory::class);
    }

    public function shipmentStatus()
    {
        return $this->belongsTo(ShipmentStatus::class, 'shipment_status');
    }

    public function serviceDetail()
    {
        return $this->belongsTo(ServiceDetail::class, 'id_service_detail');
    }

    public function urgencyLtl()
    {
        return $this->belongsTo(UrgencyLtl::class, 'urgency_ltl_id');
    }

    public function modality()
    {
        return $this->belongsTo(Modality::class, 'modality_id');
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }
}
