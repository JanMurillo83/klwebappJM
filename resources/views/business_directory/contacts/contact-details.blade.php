<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Directory Details') }} - {{ $directory->type }} - {{ $directory->company }}
        </h2>
    </x-slot>


    <div class="ms-12 me-12">
        <!-- Información del directorio -->
        <div class="flex flex-wrap">
            <div class="w-full flex flex-wrap mt-5">
                <div class="w-full md:w-1/2 lg:w-1/3 xl:w-2/12 p-1">
                    <strong>Nickname:</strong> {{ $directory->nickname }}
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 xl:w-2/12 p-1">
                    <strong>Billing:</strong> {{ $directory->billing_currency }}
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 xl:w-3/12 p-1">
                    <strong>RFC/Tax ID:</strong> {{ $directory->rfc_tax_id }}
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 xl:w-5/12 p-1">
                    <strong>Street Address:</strong> {{ $directory->street_address }}
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 xl:w-2/12 p-1">
                    <strong>City:</strong> {{ $directory->city }}
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 xl:w-2/12 p-1">
                    <strong>State:</strong> {{ $directory->state }}
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 xl:w-2/12 p-1">
                    <strong>P. Code:</strong> {{ $directory->postal_code }}
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 xl:w-2/12 p-1">
                    <strong>Phone:</strong> {{ $directory->phone }}
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 xl:w-4/12 p-1">
                    <strong>Email:</strong> {{ $directory->email }}
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 xl:w-12/12 p-1">
                    <strong>Notes:</strong> {{ $directory->notes }}
                </div>
            </div>
        </div>
        <div class="mt-3">
            <x-button>
                <a href="{{ route('business-directory.edit', $directory->id) }}">Edit {{ $directory->type }}</a>
            </x-button>
            
        </div>

    </div>

    <div class="ms-12 me-12 mt-8">
        <livewire:contacts-list :directoryId="$directory->id" />
    </div>
</x-app-layout>