<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\User;// Importa el modelo User
use Livewire\WithPagination;

class UsersList extends Component
{
    use WithPagination;
    public $search;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {
        // Combine search and pagination in one query
        $users = User::where('name', 'like', '%' . $this->search . '%')->orwhere('email', 'like', '%' . $this->search . '%')->paginate(10); // Specify the number of items you want per page
        return view('users.users-list', compact('users'));
    }

    public function refreshComponent()
    {
        // This method intentionally left blank.
    }

}