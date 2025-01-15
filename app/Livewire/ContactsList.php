<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Contact;

class ContactsList extends Component
{
    use WithPagination;

    public $search = '';
    public $directoryId;
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $showCreateModal = false; // Estado del modal para crear
    public $contactIdToDelete;
    public $contactId;
    public $name, $last_name, $office_phone, $cellphone, $email, $working_hours, $notes;
    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'directoryId' => 'required|exists:business_directories,id',
        'name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'office_phone' => 'nullable|string|max:20',
        'cellphone' => 'nullable|string|max:20',
        'working_hours' => 'nullable|string|max:255',
        'notes' => 'nullable|string',
    ];

    public function mount($directoryId)
    {
        $this->directoryId = $directoryId;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
        $this->showEditModal = true;
        $this->loadContact($id);
    }

    // Método para mostrar el modal de creación
    public function create()
    {
        $this->resetModal(); // Limpia los datos del formulario
        $this->showCreateModal = true; // Muestra el modal
    }

    public function createContact()
    {
        $this->validate();

        Contact::create([
            'directory_entry_id' => $this->directoryId, // Asegúrate de que este valor se pasa correctamente
            'name' => $this->name,
            'last_name' => $this->last_name,
            'office_phone' => $this->office_phone,
            'cellphone' => $this->cellphone,
            'email' => $this->email,
            'working_hours' => $this->working_hours,
            'notes' => $this->notes,
        ]);

        // $this->resetInputFields();
        $this->showCreateModal = false;

        session()->flash('success', 'Contact created successfully!');
    }
    

    public function updateContact()
    {
        $this->validate();

        $contact = Contact::findOrFail($this->contactId);
        $contact->update($this->getContactData());

        $this->resetModal();
        session()->flash('success', 'Contact updated successfully!');
    }

    public function resetModal()
    {
        $this->showEditModal = false;
        $this->reset(['name', 'last_name', 'office_phone', 'cellphone', 'email', 'working_hours', 'notes', 'contactId']);
    }

    public function confirmDelete($id)
    {
        $this->contactIdToDelete = $id;
        $this->showDeleteModal = true;
    }

    public function deleteContact()
    {
        Contact::findOrFail($this->contactIdToDelete)->delete();

        $this->reset(['showDeleteModal', 'contactIdToDelete']);
        session()->flash('message', 'Contact deleted successfully.');
    }

    public function render()
    {
        $contacts = Contact::select('id', 'name', 'last_name', 'email', 'office_phone', 'cellphone', 'working_hours', 'notes')
            ->where('directory_entry_id', $this->directoryId)
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('business_directory.contacts.contacts-list', compact('contacts'));
    }

    private function loadContact($id)
    {
        $contact = Contact::findOrFail($id);
        $this->contactId = $contact->id;
        $this->name = $contact->name;
        $this->last_name = $contact->last_name;
        $this->office_phone = $contact->office_phone;
        $this->cellphone = $contact->cellphone;
        $this->email = $contact->email;
        $this->working_hours = $contact->working_hours;
        $this->notes = $contact->notes;
    }

    private function getContactData()
    {
        return [
            'name' => $this->name,
            'last_name' => $this->last_name,
            'office_phone' => $this->office_phone,
            'cellphone' => $this->cellphone,
            'email' => $this->email,
            'working_hours' => $this->working_hours,
            'notes' => $this->notes,
        ];
    }

    public function refreshComponent()
    {
        // This method intentionally left blank.
    }
}