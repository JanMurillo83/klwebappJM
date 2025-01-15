<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrgencyLtl extends Model
{
    use HasFactory;

    protected $table = 'urgency_ltl';

    protected $fillable = [
        'type',
        'emergency_company',
        'company_ID',
        'phone',
    ];

    // Relación con urgency_types
    public function urgencyType()
    {
        return $this->belongsTo(UrgencyType::class, 'type');
    }

    // Relación inversa con Service
    public function service()
    {
        return $this->hasOne(Service::class, 'urgency_ltl_id');
    }
    
}
