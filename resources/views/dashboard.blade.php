<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    {{-- @section('content') --}}
    <div class="py-1 md:mx-auto">
        <div class="">
            <div class="overflow-hidden bg-white sm:rounded-lg">
                <x-welcome />
            </div>
        </div>
    </div>
    {{-- @endsection --}}
</x-app-layout>
