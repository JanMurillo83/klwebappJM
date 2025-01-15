<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ExchangeRate;
use Carbon\Carbon;

class ExchangeRateModal extends Component
{
    public $isOpen = false; // Controla si el modal está abierto o cerrado
    public $exchange_rate; // Para el formulario
    public $current_rate; // Tipo de cambio actual
    public $effective_date; // Fecha del tipo de cambio actual

    protected $rules = [
        'exchange_rate' => 'required|numeric|min:0',
    ];

    public function mount()
    {
        $this->checkExchangeRateForToday();
    }

    /**
     * Verificar si existe un tipo de cambio para el día actual
     */
    public function checkExchangeRateForToday()
    {
        $today = Carbon::today();
        $latestRate = ExchangeRate::whereDate('effective_date', $today)->first();

        if ($latestRate) {
            $this->current_rate = $latestRate->exchange_rate;
            $this->effective_date = $latestRate->effective_date->format('M d, Y');
        } else {
            $this->current_rate = null;
            $this->effective_date = null;

            // Opción: Notificar al usuario
            session()->flash('warning', 'No exchange rate set for today. Please update it.');
        }
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset(['exchange_rate']); // Limpia los campos del formulario
    }

    public function saveExchangeRate()
    {
        $this->validate();

        ExchangeRate::create([
            'exchange_rate' => $this->exchange_rate,
            'effective_date' => Carbon::today(), // Fecha actual
        ]);

        // Actualizar los valores actuales
        $this->current_rate = $this->exchange_rate;
        $this->effective_date = Carbon::today()->format('M d, Y');

        $this->closeModal();

        session()->flash('success', 'Exchange rate updated successfully.');
    }

    public function render()
    {
        return view('exchange_rates.exchange-rate-modal');
    }
}