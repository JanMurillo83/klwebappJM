<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BusinessDirectory;

class CrudBusinessDirectory extends Component
{
    public $entries;
    public $type;
    public $company;
    public $nickname;
    public $billing_currency;
    public $rfc_tax_id;
    public $street_address;
    public $building_number;
    public $neighborhood;
    public $city;
    public $state;
    public $postal_code;
    public $country;
    public $phone;
    public $website;
    public $email;
    public $credit_days;
    public $credit_expiration_date;
    public $free_loading_unloading_hours;
    public $notes;
    public $add_document;
    public $document_expiration_date;
    public $picture;
    public $tarifario;

    public function create()
    {
        $this->validate([
            'type' => 'required',
            'company' => 'required',
            'nickname' => 'required',
            'billing_currency' => 'required',
            'rfc_tax_id' => 'required',
            'street_address' => 'required',
            'building_number' => 'required',
            'neighborhood' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);

        BusinessDirectory::create([
            'type' => $this->type,
            'company' => $this->company,
            'nickname' => $this->nickname,
            'billing_currency' => $this->billing_currency,
            'rfc_tax_id' => $this->rfc_tax_id,
            'street_address' => $this->street_address,
            'building_number' => $this->building_number,
            'neighborhood' => $this->neighborhood,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postal_code,
            'country' => $this->country,
            'phone' => $this->phone,
            'website' => $this->website,
            'email' => $this->email,
            'credit_days' => $this->credit_days,
            'credit_expiration_date' => $this->credit_expiration_date,
            'free_loading_unloading_hours' => $this->free_loading_unloading_hours,
            'notes' => $this->notes,
            'add_document' => $this->add_document,
            'document_expiration_date' => $this->document_expiration_date,
            'picture' => $this->picture,
            'tarifario' => $this->tarifario,
        ]);

        // $this->resetInputFields();
        $this->entries = BusinessDirectory::all();
    }

    private function resetInputFields()
    {
        $this->type = '';
        $this->company = '';
        $this->nickname = '';
        $this->billing_currency = '';
        $this->rfc_tax_id = '';
        $this->street_address = '';
        $this->building_number = '';
        $this->neighborhood = '';
        $this->city = '';
        $this->state = '';
        $this->postal_code = '';
        $this->country = '';
        $this->phone = '';
        $this->website = '';
        $this->email = '';
        $this->credit_days = '';
        $this->credit_expiration_date = '';
        $this->free_loading_unloading_hours = '';
        $this->notes = '';
        $this->add_document = '';
        $this->document_expiration_date = '';
        $this->picture = '';
        $this->tarifario = '';
    }
}