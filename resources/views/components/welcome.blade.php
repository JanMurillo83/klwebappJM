<div class="p-2 bg-white ms-12 me-12">
    <!-- Service buttons -->
    <div class="flex flex-wrap gap-x-2 gap-y-2">
        {{-- <x-button class="bg-red-500">
            {{ __('FTL') }}
        </x-button> --}}
        <a href="{{ route('shipment.dashboard') }}" class="inline-block px-4 py-2 text-white bg-red-600 rounded hover:bg-red-600 focus:outline-none focus:shadow-outline">
            {{ __('Shipments Panel') }}
        </a>

        <!--<x-button class="bg-red-500">
            {{ __('LTL') }}
        </x-button>
        <x-button class="bg-red-500">
            {{ __('C.Drayage') }}
        </x-button>
        <x-button class="bg-red-500">
            {{ __('Hand Carrier') }}
        </x-button>
        <x-button class="bg-red-500">
            {{ __('Trailer Rental') }}
        </x-button>
        <x-button class="bg-red-500">
            {{ __('Charter') }}
        </x-button>
        <x-button class="bg-red-500">
            {{ __('Air Freight') }}
        </x-button>
        <x-button class="bg-red-500">
            {{ __('Warehouse') }}
        </x-button>
        <x-button class="bg-red-500">
            {{ __('C. Broker') }}
        </x-button>
        <x-button class="bg-red-500">
            {{ __('D. Transfer') }}
        </x-button>-->
    </div>



<div class="relative mt-12 overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Load ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Last Update
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Coordinator
                </th>
                <th scope="col" class="px-6 py-3">
                    Origin
                </th>
                <th scope="col" class="px-6 py-3">
                    destination
                </th>
                <th scope="col" class="px-6 py-3">
                    watch
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    1
                </th>
                <td class="px-6 py-4">
                    2:30
                </td>
                <td class="px-6 py-4">
                    Canceled
                </td>
                <td class="px-6 py-4">
                    Joanna
                </td>
                 <td class="px-6 py-4">
                    Texas
                </td>
                 <td class="px-6 py-4">
                    Ramos A.
                </td>
                <td class="px-6 py-4">
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>

                </td>
            </tr>
        </tbody>
    </table>
</div>

</div>
</div>
