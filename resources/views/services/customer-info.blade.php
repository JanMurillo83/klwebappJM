<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-2 p-2">
    <div class="divisor mt-5 md:col-span-12">
        <h2 class="text-red-500 font-bold mb-1">Customer
            <span class="text-black font-bold">Info</span>
        </h2>
        <hr>
    </div>
    <div class="mt-2 md:col-span-3">
        <x-label for="customer" :value="__('Customer')" class="text-xs" />
        <select wire:model="customer" wire:change="refreshPreview" id="customer" name="customer"
            class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs text-gray-800 placeholder:text-gray-400">
            <option value="">Select customer</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->company }}</option>
            @endforeach
        </select>
    </div>
    <div class="mt-2 md:col-span-2">
        <x-label for="rate_to_customer" :value="__('Rate C.')" class="text-xs" />
        <x-input wire:input="refreshPreview" wire:model="rate_to_customer" id="rate_to_customer" type="text"
            name="rate_to_customer" class="block mt-1 w-full" />
    </div>
    <div class="mt-2 md:col-span-1">
        <x-label for="currency" :value="__('Currency')" class="text-xs" />
        <select wire:model="currency" wire:change="refreshPreview" id="currency" name="currency"
            class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs text-gray-800 placeholder:text-gray-400">
            <option value="USD">USD</option>
            <option value="MXN">MXN</option>
        </select>
    </div>
    <div class="mt-2 md:col-span-2">
        <x-label for="billing_currency_reference" :value="__('Billing C. Ref.')" class="text-xs" />
        <x-input wire:input="refreshPreview" wire:model="billing_currency_reference" id="billing_currency_reference"
            type="text" name="billing_currency_reference" class="block mt-1 w-full" />
    </div>

    <div class="mt-2 md:col-span-2">
        <x-label for="pickup_number" :value="__('Pickup No.')" class="text-xs" />
        <x-input 
        wire:model="pickup_number" 
        id="pickup_number" 
        type="text" 
        name="pickup_number" 
        class="block mt-1 w-full disabled:bg-gray-300 disabled:text-gray-300 disabled:cursor-not-allowed" 
        :disabled="$disablePickupNo" 
    />
    </div>
    <div class="mt-2 md:col-span-2">
        <x-label for="shipment_status" :value="__('Shipment Status')" class="text-xs" />
        <select wire:model="shipment_status" wire:change="refreshPreview" id="shipment_status" name="shipment_status"
            class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs text-gray-800 placeholder:text-gray-400">
            <option value="">Select status</option>
            @foreach ($shipmentStatuses as $status)
                <option value="{{ $status->id }}">{{ $status->name }}</option>
            @endforeach
        </select>
    </div>
</div>
