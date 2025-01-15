<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrgencyType extends Model
{
    use HasFactory;

    protected $table = 'urgency_types';

    // Campos que pueden ser asignados en masa
    protected $fillable = [
        'name',
        'description',
    ];

    // Relación con UrgencyLtl
    public function urgencies()
    {
        return $this->hasMany(UrgencyLtl::class, 'type');
    }
}
