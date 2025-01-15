<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Business Directory') }}
        </h2>
    </x-slot>
    <div class="ms-8 me-12 mt-6">
        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse bg-white shadow-md rounded-lg">
                <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left">ID</th>
                        <th class="py-3 px-6 text-left">Rate</th>
                        <th class="py-3 px-6 text-left">Effective Date</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm font-light">
                    @foreach ($exchangeRates as $rate)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left">{{ $rate->id }}</td>
                            <td class="py-3 px-6 text-left">{{ number_format($rate->exchange_rate, 2) }}</td>
                            <td class="py-3 px-6 text-left">{{ $rate->effective_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $exchangeRates->links('pagination::tailwind') }}
        </div>
    </div>
</x-app-layout>
