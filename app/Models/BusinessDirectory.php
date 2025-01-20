<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessDirectory extends Model
{
    use HasFactory;
    protected $table = 'business_directories';

    protected $fillable = [
        'type',
        'company',
        'nickname',
        'billing_currency',
        'rfc_tax_id',
        'street_address',
        'building_number',
        'neighborhood',
        'city',
        'state',
        'postal_code',
        'country',
        'phone',
        'website',
        'email',
        'billing_reference',
        'custom_start_number',
        'credit_days',
        'credit_expiration_date',
        'free_loading_unloading_hours',
        'factory_company_id',
        'notes',
        'add_document',
        'document_expiration_date',
        'picture',
        'tarifario'
    ];

    public static function byType($type)
    {
        return static::where('type', $type); // Devuelve un Builder
    }


    public function contacts()
    {
        return $this->hasMany(Contact::class, 'directory_entry_id');
    }

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'directory_entry_id');
    }

    public function getAllAttributes()
    {
        $columns = $this->getFillable();
        $attributes = $this->getAttributes();
        foreach ($columns as $column)
        {
            if (!array_key_exists($column, $attributes))
            {
                $attributes[$column] = null;
            }
        }
        return $attributes;
    }
}
