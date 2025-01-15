<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catalog Data') }}
        </h2>
    </x-slot>

    

    <div class="max-w-sm ms-12 me-12 mt-6 mx-auto bg-white rounded-lg overflow-hidden">
        <ul class="divide-y divide-gray-200">
            <!-- Handling Type -->
            <li>
                <a href="/handling-type/list" class="block px-6 py-2 hover:bg-red-100 flex items-center">
                    <div class="text-gray-900 text-lg font-bold flex-1">Handling Type</div> <svg
                        xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </li> <!-- Material Type -->
            <li> <a href="/material-type/list" class="block px-6 py-2 hover:bg-red-100 flex items-center">
                    <div class="text-gray-900 text-lg font-bold flex-1">Material Type</div> <svg
                        xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a> </li> <!-- Freight Classes -->
            <li> <a href="/freight-classes/list" class="block px-6 py-2 hover:bg-red-100 flex items-center">
                    <div class="text-gray-900 text-lg font-bold flex-1">Freight Classes</div> <svg
                        xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a> </li>
    
        </ul>
    </div>

</x-app-layout>
