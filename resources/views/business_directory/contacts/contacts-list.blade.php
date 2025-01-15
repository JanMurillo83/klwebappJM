<div>
    <div class="mb-10 mt-10">
        <div class="table-header">
            {{-- Campo de búsqueda --}}
            <x-input placeholder="Search Contact" wire:model="search" wire:keydown="refreshComponent" class="mb-4" />
            <x-button wire:click="create" class="bg-green-500 hover:bg-green-700 text-white ml-3">
                Add New Contact
            </x-button>

        </div>

        {{-- Verifica si hay contactos disponibles --}}
        @if ($contacts->count())
            <table class="min-w-full mt-4">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-2 text-left">ID</th>
                        <th scope="col" class="px-4 py-2 text-left">Name</th>
                        <th scope="col" class="px-4 py-2 text-left">Last Name</th>
                        <th scope="col" class="px-4 py-2 text-left">Phone</th>
                        <th scope="col" class="px-4 py-2 text-left">Email</th>
                        <th scope="col" class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Mostrar los contactos --}}
                    @foreach ($contacts as $contact)
                        <tr
                            class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                            <td class="px-4 py-2">{{ $contact->id }}</td>
                            <td class="px-4 py-2">{{ $contact->name }}</td>
                            <td class="px-4 py-2">{{ $contact->last_name }}</td>
                            <td class="px-4 py-2">{{ $contact->cellphone ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $contact->email }}</td>
                            <td class="px-4 py-2">
                                <x-button wire:click="edit({{ $contact->id }})"
                                    class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                    Edit
                                </x-button>
                                <x-button wire:click="confirmDelete({{ $contact->id }})"
                                    class="bg-red-500 hover:bg-red-700 text-white">
                                    Delete
                                </x-button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Paginación --}}
            <div class="mt-4">
                {{ $contacts->links() }}
            </div>
        @else
            <div class="mt-6">
                <p>No contacts found.</p>
            </div>
        @endif
    </div>

     {{-- Modal para crear --}}
     <x-modal wire:model="showCreateModal">
        <div class="px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-800">Create Contact </h2>
            <div class="mt-4 space-y-4">
                <x-label for="name" value="Name" />
                <x-input id="name" wire:model.defer="name" class="block w-full mt-1" />

                <x-label for="last_name" value="Last Name" />
                <x-input id="last_name" wire:model.defer="last_name" class="block w-full mt-1" />

                <x-label for="email" value="Email" />
                <x-input id="email" wire:model.defer="email" type="email" class="block w-full mt-1" />

                <x-label for="cellphone" value="Phone" />
                <x-input id="cellphone" wire:model.defer="cellphone" class="block w-full mt-1" />

                <x-label for="notes" value="Notes" />
                <textarea id="notes" wire:model.defer="notes" class="block w-full mt-1"></textarea>
            </div>
        </div>
        <div class="px-6 py-4 bg-gray-100 flex justify-end space-x-4">
            <x-button wire:click="createContact" class="bg-green-500 hover:bg-green-700 text-white">Save</x-button>
            <x-button wire:click="$set('showCreateModal', false)"
                class="bg-gray-500 hover:bg-gray-700 text-white">Cancel</x-button>
        </div>
    </x-modal>

    {{-- Modal para editar --}}
    <x-modal wire:model="showEditModal">
        <div class="px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-800">Edit Contact</h2>
            <div class="mt-4 space-y-4">
                <x-label for="name" value="Name" />
                <x-input id="name" wire:model.defer="name" class="block w-full mt-1" />

                <x-label for="last_name" value="Last Name" />
                <x-input id="last_name" wire:model.defer="last_name" class="block w-full mt-1" />

                <x-label for="email" value="Email" />
                <x-input id="email" wire:model.defer="email" type="email" class="block w-full mt-1" />

                <x-label for="cellphone" value="Phone" />
                <x-input id="cellphone" wire:model.defer="cellphone" class="block w-full mt-1" />

                <x-label for="notes" value="Notes" />
                <textarea id="notes" wire:model.defer="notes" class="block w-full mt-1"></textarea>
            </div>
        </div>
        <div class="px-6 py-4 bg-gray-100 flex justify-end space-x-4">
            <x-button wire:click="updateContact" class="bg-green-500 hover:bg-green-700 text-white">Save</x-button>
            <x-button wire:click="$set('showEditModal', false)"
                class="bg-gray-500 hover:bg-gray-700 text-white">Cancel</x-button>
        </div>
    </x-modal>
    {{-- Modal para eliminar --}}
    <x-modal wire:model="showDeleteModal">
        <div class="px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-800">Delete Contact</h2>
            <p class="mt-4">Are you sure you want to delete this contact? This action cannot be undone.</p>
        </div>
        <div class="px-6 py-4 bg-gray-100 flex justify-end space-x-4">
            <x-button wire:click="deleteContact" class="bg-red-500 hover:bg-red-700 text-white">Delete</x-button>
            <x-button wire:click="$set('showDeleteModal', false)"
                class="bg-gray-500 hover:bg-gray-700 text-white">Cancel</x-button>
        </div>
    </x-modal>
    
</div>
