<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\BusinessDirectory;
use Illuminate\Database\Seeder;

class BusinessDirectorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BusinessDirectory::create([
            'type' => 'station',
            'company' => 'Company One',
            'nickname' => 'Comp1',
            'billing_currency' => 'USD',
            'rfc_tax_id' => 'RFC123456789',
            'street_address' => '123 Main St',
            'building_number' => '1A',
            'neighborhood' => 'Downtown',
            'city' => 'Metropolis',
            'state' => 'StateOne',
            'postal_code' => '12345',
            'country' => 'CountryOne',
            'phone' => '555-1234',
            'website' => 'https://companyone.com',
            'email' => 'info@companyone.com',
            'credit_days' => 30,
            'credit_expiration_date' => '2024-12-31',
            'free_loading_unloading_hours' => 2,
            'notes' => 'Notes for Company One',
            'add_document' => 'https://companyone.com/document.pdf',
            'document_expiration_date' => '2025-01-01',
            'picture' => 'https://companyone.com/picture.jpg',
            'tarifario' => 'Tarifario details for Company One',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
