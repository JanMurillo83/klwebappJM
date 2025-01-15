<div>
    {{-- Botón para abrir el modal --}}
    <button wire:click="openModal" class="mt-4 text-left">
        @if ($current_rate)
            <strong>Exchange</strong> <strong class="text-red-500">Rate</strong>: <strong> ${{ $current_rate }} </strong>
            <p class="text-xs text-gray-500 italic">Effective: {{ $effective_date }}</p>
        @else
            No exchange rate set. Click to update.
        @endif
    </button>

    @if (session('warning'))
        <div class="text-yellow-500 text-sm italic">
            {{ session('warning') }}
        </div>
    @endif


    {{-- Modal --}}
    <x-modal wire:model="isOpen">
        <div class="px-6 py-4">
            <h2 class="text-lg font-bold text-gray-700">Update Exchange Rate</h2>
        </div>

        <form wire:submit.prevent="saveExchangeRate" class="px-6 py-4">
            <div class="mb-4">
                <label for="exchange_rate" class="block text-gray-700">Exchange Rate (USD to MXN)</label>
                <input type="number" step="0.000001" wire:model.defer="exchange_rate" id="exchange_rate"
                    class="w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-400"
                    required>
                @error('exchange_rate')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex justify-end">
                <button type="button" wire:click="closeModal"
                    class="bg-gray-900 text-white px-4 py-2 rounded hover:bg-gray-700 mr-2">
                    Cancel
                </button>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Save
                </button>
            </div>
        </form>
    </x-modal>
</div>
