<?php

namespace App\Livewire;

use Livewire\Component;

class ShipperConsigneeSection extends Component
{
    public $stations;
    public $shipperStopOffs = [];
    public $consigneeStopOffs = [];
    public $pickup_station;
    public $delivery_date_requested;
    public $delivery_time_requested;
    public $consignee_station;
    public $requested_pickup_date;
    public $pickup_time;
    public $border_crossing_date;

    public function mount($stations, $pickup_station, $consignee_station)
    {
        $this->stations = $stations;
        $this->pickup_station = $pickup_station;
        $this->consignee_station = $consignee_station;

        // Inicializar estructuras de datos
        $this->shipperStopOffs = [['id' => uniqid(), 'station_id' => null]];
        $this->consigneeStopOffs = [['id' => uniqid(), 'station_id' => null]];
    }

    public function updated($propertyName)
    {
        $propertyValue = $this->getPropertyValue($propertyName);

        $this->dispatch('updatePreview', [
            'property' => $propertyName,
            'value' => $propertyValue,
        ]);
    }

    public function addStopOff($type)
    {
        $stopOff = ['id' => uniqid(), 'station_id' => null];

        if ($type === 'shipper') {
            $this->shipperStopOffs[] = $stopOff;
        } elseif ($type === 'consignee') {
            $this->consigneeStopOffs[] = $stopOff;
        }
    
        $this->dispatch('updateStopOffs', [
            'shipper' => $this->shipperStopOffs,
            'consignee' => $this->consigneeStopOffs,
        ]);
    }

    public function removeStopOff($type, $id)
    {
        if ($type === 'shipper') {
            $this->shipperStopOffs = array_values(array_filter($this->shipperStopOffs, function ($stopOff) use ($id) {
                return $stopOff['id'] !== $id;
            }));
        } elseif ($type === 'consignee') {
            $this->consigneeStopOffs = array_values(array_filter($this->consigneeStopOffs, function ($stopOff) use ($id) {
                return $stopOff['id'] !== $id;
            }));
        }
    
        $this->dispatch('updateStopOffs', [
            'shipper' => $this->shipperStopOffs,
            'consignee' => $this->consigneeStopOffs,
        ]);
    }

    public function updateStopOffStation($type, $index, $value)
    {
        if ($type === 'shipper') {
            $this->shipperStopOffs[$index]['station_id'] = $value;
        } elseif ($type === 'consignee') {
            $this->consigneeStopOffs[$index]['station_id'] = $value;
        }

        $this->dispatch('updateStopOffs', [
            'shipper' => $this->shipperStopOffs,
            'consignee' => $this->consigneeStopOffs,
        ]);
    }

    public function updatePreview($propertyName, $value)
    {
        $this->$propertyName = $value;

        $this->dispatch('updatePreview', [
            'property' => $propertyName,
            'value' => $value,
        ]);
    }

    public function render()
    {
        return view('services.shipper-consignee-section');
    }

    public function refreshPreview()
    {
        // Esto solo asegura que se refresque el componente.
    }
}