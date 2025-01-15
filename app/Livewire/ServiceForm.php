<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\{
    Service,
    BusinessDirectory,
    ShipmentStatus,
    ServiceDetail,
    HandlingType,
    MaterialType,
    FreightClass,
    UrgencyType,
    Modality,
    Uom,
    ExchangeRate,
};

use App\Services\{
    // ServiceRegistration,
    CargoRegistration,
    ShipperRegistration,
    ConsigneeRegistration,
    UrgencyLtlRegistration,
    StopOffRegistration,
};

use Illuminate\Support\Facades\Log;

class ServiceForm extends Component
{
    public $service_id;

    public $customer;
    public $rate_to_customer;
    public $currency = 'USD';
    public $billing_currency_reference;
    public $pickup_number;
    public $customers;
    public $selectedCustomer;
    public $shipment_status;
    public $selectedShipmentStatus;

    public $suppliers;
    public $stations;

    public $service_detail_id;
    public $service_details;

    public $handling_types;
    public $handling_type;

    public $material_type;
    public $materialTypes;

    public $freight_class;
    public $freightClasses;

    public $expedited = false;
    public $hazmat = false;
    public $team_driver = false;
    public $round_trip = false;

    public $un_number;
    public $count;
    public $stackable = false;
    public $weight;
    public $length;
    public $width;
    public $height;
    public $uom_weight;
    public $uom_dimensions;
    public $total_yards;
    public $uom_weight_options;
    public $uom_dimensions_options;

    public $shipperStopOffs = [];
    public $consigneeStopOffs = [];
    
    public $consignee_station;
    public $delivery_date_requested; // Consignees
    public $delivery_time_requested; // Consignees
    public $actual_delivery_date; // Consignees
    public $actual_time; // Consignees
    public $withdrawal_date; // Consignees

    public $pickup_station;
    public $requested_pickup_date; // Shippers
    public $pickup_time; // Shippers
    public $scheduled_border_crossing_date; // Shippers
    public $drop_reception_date; // Shippers

    //urgency_ltl urgency_types
    public $urgency_types;
    public $urgency_type;
    public $emergency_company;
    public $company_id;
    public $phone;

    public $modality_type;
    public $container;
    public $size;
    public $modality_weight;
    public $modality_uom;
    public $modality_material_type;

    public $disablePickupNo = false;

    public $isSaving = false;

    protected $listeners = [
        'updatePreview' => 'handleUpdatePreview',
        'updateCustomerInfo' => 'updateCustomerInfo',
        'updateStopOffs' => 'handleUpdateStopOffs',
    ];

    public function mount()
    {
        $this->loadData();
    }

    private function loadData()
    {
        $this->suppliers = BusinessDirectory::byType('supplier')->get();
        $this->stations = BusinessDirectory::byType('station')->get();
        $this->service_details = ServiceDetail::all();
        $this->handling_types = HandlingType::all();
        $this->materialTypes = MaterialType::all();
        $this->freightClasses = FreightClass::all();
        $this->urgency_types = UrgencyType::all();
        $this->uom_weight_options = Uom::where('description', 'Weight Units')->get();
        $this->uom_dimensions_options = Uom::where('description', 'Units of Length')->get();
    }

    public function updateCustomerInfo($data)
    {
        foreach ($data as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    } 

    public function handleUpdatePreview($data)
    {
        if (isset($data['property'], $data['value'])) {
            $this->{$data['property']} = $data['value'];

            if ($data['property'] === 'customer') {
                $this->selectedCustomer = BusinessDirectory::find($data['value']);
            }

            if ($data['property'] === 'shipment_status') {
                $this->selectedShipmentStatus = ShipmentStatus::find($data['value']);
            }
        }
    }

    public function handleUpdateStopOffs($data)
    {
        $this->shipperStopOffs = $data['shipper'] ?? [];
        $this->consigneeStopOffs = $data['consignee'] ?? [];
    }

    public function refreshPreview()
    {
        // Esto solo asegura que se refresque el componente.
    }

    public function saveService()
    {
        if ($this->isSaving) {
            return; 
        }
    
        $this->isSaving = true;
    
        try {
            $this->validateData(); // Validación de datos
    
            // Obtiene el servicio seleccionado
            $selectedService = $this->service_details->firstWhere('id', $this->service_detail_id);
    
            if (!$selectedService) {
                throw new \Exception('Invalid service selected.');
            }
    
            // Registra UrgencyLtl si aplica
            $urgencyLtlData = $this->getUrgencyLtlData($selectedService);
            $urgencyLtl = $urgencyLtlData ? UrgencyLtlRegistration::createUrgencyLtl($urgencyLtlData) : null;
    
            // Registra Modality si aplica
            $modalityData = $this->getModalityData($selectedService);
            $modality = $modalityData ? Modality::create($modalityData) : null;
    
            // Registra Cargo si aplica
            $cargo = null;
            if (!$this->isServiceExemptFromCargo($selectedService)) {
                $cargo = CargoRegistration::createCargo($this->getCargoData());
                if (!$cargo || !$cargo->id) {
                    throw new \Exception('Failed to create Cargo or ID is missing.');
                }
            }
    
            // Prepara los datos del servicio
            $serviceData = $this->getServiceData($cargo?->id, $urgencyLtl, $modality);
    
            // Registra el servicio
            $service = Service::create($serviceData);
            $this->service_id = $service->id;
    
            // Registra shipper, consignee y stop-offs
            ShipperRegistration::createShipper($this->getShipperData());
            ConsigneeRegistration::createConsignee($this->getConsigneeData());
            $this->registerStopOffs();
    
            session()->flash('message', 'Service registered successfully!');
            return redirect()->route('dashboard'); 
    
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        } finally {
            $this->isSaving = false;
        }
    }
    

    private function validateData()
    {
        if (is_null($this->customer)) {
            throw new \Exception('Please select a customer.');
        }

        if (empty($this->shipperStopOffs) || empty($this->consigneeStopOffs)) {
            throw new \Exception('Stop-offs for shipper and consignee are required.');
        }
    }

    private function isServiceExemptFromCargo($selectedService)
    {
        $exemptServices = [
            'Container Drayage',
            'Trailer Rental',
            'Us Customs Broker',
            'Transfer',
        ];

        foreach ($exemptServices as $exemptService) {
            if (str_contains($selectedService->name, $exemptService)) {
                return true;
            }
        }

        return false;
    }

    private function getCargoData()
    {
        return [
            'handling_type' => $this->handling_type,
            'material_type' => $this->material_type,
            'freight_class' => $this->freight_class,
            'count' => $this->count,
            'stackable' => $this->stackable,
            'weight' => $this->weight,
            'uom_weight' => $this->uom_weight,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'uom_dimensions' => $this->uom_dimensions,
            'total_yards' => $this->total_yards,
        ];
    }
    

    private function getUrgencyLtlData($selectedService)
    {
        // Verifica si el servicio seleccionado requiere UrgencyLtl
        if (str_contains($selectedService->name, 'LTL') || str_contains($selectedService->name, 'Air Freight')) {
            return [
                'type' => $this->urgency_type,
                'emergency_company' => $this->emergency_company,
                'company_ID' => $this->company_id,
                'phone' => $this->phone,
            ];
        }
    
        return null; // Si no aplica, devuelve null
    }

    private function getModalityData($selectedService)
    {
        // Verifica si el servicio seleccionado requiere Modality
        if (str_contains($selectedService->name, 'Container Drayage')) {
            return [
                'type' => $this->modality_type,
                'container' => $this->container,
                'size' => $this->size,
                'weight' => $this->modality_weight,
                'uom' => $this->modality_uom,
                'material_type' => $this->modality_material_type,
            ];
        }

        return null; // Si no aplica, devuelve null
    }


    private function getServiceData($cargoId = null, $urgencyLtl = null, $modality = null)
    {
        $latestExchangeRate = ExchangeRate::latest('effective_date')->first();
    
        return [
            'exchange_rate_id' => $latestExchangeRate->id ?? null,
            'user_id' => auth()->id(),
            'business_directory_id' => $this->customer,
            'shipment_status' => $this->shipment_status,
            'id_service_detail' => $this->service_detail_id,
            'cargo_id' => $cargoId, // Puede ser null si el servicio no requiere cargo
            'rate_to_customer' => $this->rate_to_customer,
            'currency' => $this->currency,
            'billing_customer_reference' => $this->billing_currency_reference,
            'pickup_number' => $this->pickup_number,
            'expedited' => $this->expedited,
            'hazmat' => $this->hazmat,
            'team_driver' => $this->team_driver,
            'round_trip' => $this->round_trip,
            'un_number' => $this->un_number,
            'urgency_ltl_id' => $urgencyLtl?->id ?? null,
            'modality_id' => $modality?->id ?? null,
            'manual_status' => null,
            'time_status' => null,
            'eta_delivery_status' => null,
            'notes_status' => null,
            'sub_services' => null,
        ];
    }
    
    private function getShipperData()
    {
        return [
            'service_id' => $this->service_id,
            'requested_pickup_date' => $this->requested_pickup_date,
            'time' => $this->pickup_time ?? '00:00:00',
            'scheduled_border_crossing_date' => $this->scheduled_border_crossing_date,
            'drop_reception_date' => $this->drop_reception_date,
        ];
    }

    private function getConsigneeData()
    { 
        return [
            'service_id' => $this->service_id,
            'delivery_date_requested' => $this->delivery_date_requested,
            'delivery_time_requested' => $this->delivery_time_requested,
            'actual_delivery_date' => $this->actual_delivery_date,
            'actual_time' => $this->actual_time,
            'withdrawal_date' => $this->withdrawal_date,
        ];
    }

    private function registerStopOffs()
    {
        Log::info('Registering stop-offs for shippers and consignees', [
            'pickup_station' => $this->pickup_station,
            'shipperStopOffs' => $this->shipperStopOffs,
            'consignee_station' => $this->consignee_station,
            'consigneeStopOffs' => $this->consigneeStopOffs,
        ]);
    
        // Registrar el pickup_station como la primera posición
        if (!empty($this->pickup_station)) {
            StopOffRegistration::createStopOff([
                'service_id' => $this->service_id,
                'role' => 'shipper',
                'business_directory_id' => $this->pickup_station, // Estación del shipper
                'position' => 0, // Posición en el arreglo
            ]);
    
            Log::info('Pickup station registered successfully', [
                'pickup_station' => $this->pickup_station,
            ]);
        } else {
            Log::error("Missing 'pickup_station'");
            throw new \Exception("Missing 'pickup_station'.");
        }
    
        // Registrar stop-offs para shippers
        foreach ($this->shipperStopOffs as $index => $stopOff) {
            Log::info('Processing shipper stop-off', [
                'index' => $index,
                'stopOff' => $stopOff,
            ]);
    
            if (empty($stopOff['station_id'])) {
                Log::error("Missing 'station_id' in shipper stop-off at position {$index}", [
                    'stopOff' => $stopOff,
                ]);
                throw new \Exception("Missing 'station_id' in shipper stop-off at position {$index}.");
            }
    
            StopOffRegistration::createStopOff([
                'service_id' => $this->service_id,
                'role' => 'shipper',
                'business_directory_id' => $stopOff['station_id'], // Estación del shipper
                'position' => $index + 1, // Posición en el arreglo
            ]);
    
            Log::info('Shipper stop-off registered successfully', [
                'index' => $index,
                'stopOff' => $stopOff,
            ]);
        }
    
        // Registrar el consignee_station como la primera posición
        if (!empty($this->consignee_station)) {
            StopOffRegistration::createStopOff([
                'service_id' => $this->service_id,
                'role' => 'consignee',
                'business_directory_id' => $this->consignee_station, // Estación del consignee
                'position' => 0, // Posición en el arreglo
            ]);
    
            Log::info('Consignee station registered successfully', [
                'consignee_station' => $this->consignee_station,
            ]);
        } else {
            Log::error("Missing 'consignee_station'");
            throw new \Exception("Missing 'consignee_station'.");
        }
    
        // Registrar stop-offs para consignees
        foreach ($this->consigneeStopOffs as $index => $stopOff) {
            Log::info('Processing consignee stop-off', [
                'index' => $index,
                'stopOff' => $stopOff,
            ]);
    
            if (empty($stopOff['station_id'])) {
                Log::error("Missing 'station_id' in consignee stop-off at position {$index}", [
                    'stopOff' => $stopOff,
                ]);
                throw new \Exception("Missing 'station_id' in consignee stop-off at position {$index}.");
            }
    
            StopOffRegistration::createStopOff([
                'service_id' => $this->service_id,
                'role' => 'consignee',
                'business_directory_id' => $stopOff['station_id'], // Estación del consignee
                'position' => $index + 1, // Posición en el arreglo
            ]);
    
            Log::info('Consignee stop-off registered successfully', [
                'index' => $index,
                'stopOff' => $stopOff,
            ]);
        }
    }

    public function updatedServiceDetailId($value)
    {
        $disableServiceIds = [3, 7, 8, 9, 10]; // IDs que deshabilitan el Pickup No
        $this->disablePickupNo = in_array((int)$value, $disableServiceIds);

        // Enviar evento al componente hijo
        $this->dispatch('updateDisablePickupNo', $this->disablePickupNo);
    }
    

    public function render()
    {
        return view('services.service-form', [
            'stations' => $this->stations,
            'customer' => $this->customer,
            'shipment_status' => $this->shipment_status,
            'selectedCustomer' => $this->selectedCustomer,
            'selectedShipmentStatus' => $this->selectedShipmentStatus,
            'service_details' => $this->service_details
        ]);
    }

}
