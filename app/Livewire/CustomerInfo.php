<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BusinessDirectory;
use App\Models\ShipmentStatus;

class CustomerInfo extends Component
{
    public $customer;
    public $rate_to_customer;
    public $currency = 'USD';
    public $billing_currency_reference;
    public $pickup_number;
    public $selectedCustomer;
    public $shipment_status;
    public $shipmentStatuses;
    public $selectedShipmentStatus;
    public $customers;

    public $disablePickupNo = false;

    protected $listeners = [
        'updateDisablePickupNo' => 'handleDisablePickupNo',
    ];

    public function mount($customer = null, $shipment_status = null)
    {
        $this->customers = BusinessDirectory::byType('customer')->get();
        $this->shipmentStatuses = ShipmentStatus::all();
        $this->customer = $customer;
        $this->shipment_status = $shipment_status;
    }

    public function handleDisablePickupNo($disablePickupNo)
    {
        $this->disablePickupNo = $disablePickupNo;
    }

    public function updatedDisablePickupNo($value)
    {
        if ($value) {
            // Si se deshabilita, elimina el contenido del campo
            $this->pickup_number = null;
        }
    }

    public function updated($propertyName)
    {
        $this->dispatch('updateCustomerInfo', [
            'customer' => $this->customer,
            'rate_to_customer' => $this->rate_to_customer,
            'currency' => $this->currency,
            'billing_currency_reference' => $this->billing_currency_reference,
            'pickup_number' => $this->pickup_number,
            'shipment_status' => $this->shipment_status,
        ]);
    }

    public function updatedCustomer($customerId)
    {
        $this->selectedCustomer = BusinessDirectory::find($customerId);
    
        $this->dispatch('updatePreview', [
            'property' => 'customer',
            'value' => $customerId,
        ]);
    }

    public function updatedShipmentStatus($statusId)
    {
        $this->selectedShipmentStatus = ShipmentStatus::find($statusId);

        $this->dispatch('updatePreview', [
            'property' => 'shipment_status',
            'value' => $statusId,
        ]);
    }

    public function render()
    {
        return view('services.customer-info');
    }

    public function refreshPreview()
    {
        // Esto solo asegura que se refresque el componente.
    }

    
}