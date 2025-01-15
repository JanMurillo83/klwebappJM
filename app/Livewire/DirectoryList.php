<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BusinessDirectory;
use Livewire\WithPagination;

class DirectoryList extends Component
{
    use WithPagination;

    public $search = ''; // Para el término de búsqueda

    public function updatingSearch()
    {
        // Resetear paginación cuando se actualice la búsqueda
        $this->resetPage();
    }

    public function render()
    {
        // Consulta con paginación
        $entries = BusinessDirectory::query()
            ->when($this->search, function ($query) {
                $query->where('company', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('city', 'like', '%' . $this->search . '%');
            })
            ->paginate(20); // Ajusta el número de resultados por página según sea necesario

        return view('business_directory.directory-list', compact('entries'));
    }

    public function refreshComponent()
    {
        // This method intentionally left blank.
    }
}
