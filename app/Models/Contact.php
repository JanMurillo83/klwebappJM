<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'directory_entry_id',
        'name',
        'last_name',
        'office_phone',
        'cellphone',
        'email',
        'working_hours',
        'notes',
    ];

    public function businessDirectory()
    {
        return $this->belongsTo(BusinessDirectory::class, 'directory_entry_id');
    }
}
