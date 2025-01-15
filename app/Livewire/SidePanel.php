<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\View;

class SidePanel extends Component
{
    public $closed = false;
    // public $open = false;

    public function toggleMenu()
    {
        $this->open = !$this->open;
    }

    public function render()
    {
        return view('livewire.side-panel');
    }

    public function boot()
    {
        // Compartir los enlaces con todas las vistas
        View::share('navLinks', config('navigation.links'));
    }
}