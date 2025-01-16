<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Business Directory') }}
        </h2>
    </x-slot>

    <div class="mt-6 ms-8 me-12">
        <div class="flex items-center space-x-2">
            <a href="{{ route('business-directory.create2', ['action'=>'create','id'=>0,'type' => 'customer']) }}" class="inline-block">
                <x-button>Add Customer</x-button>
            </a>

            <a href="{{ route('business-directory.create2', ['action'=>'create','id'=>0,'type' => 'station']) }}" class="inline-block">
                <x-button>Add New Station</x-button>
            </a>

            <a href="{{ route('business-directory.create2',['action'=>'create','id'=>0,'type'=>'supplier']) }}" class="inline-block">
                <x-button>Add Supplier</x-button>
            </a>
            @if (session('success'))
                <div class="px-4 text-white bg-green-500 rounded-md">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <div class="relative mt-12 overflow-x-auto">
            @livewire('directory-list')
        </div>
    </div>
</x-app-layout>
