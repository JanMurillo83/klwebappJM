<div class="lg:col-span-12 grid grid-cols-2 gap-4">
    <!-- Shipper Section -->
    <div class="pr-2">
        <h2 class="text-red-500 font-bold mb-1">Shipper</h2>
        <hr class="mb-2">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-label for="requested_pickup_date" :value="__('Requested Pickup Date')" class="text-xs" />
                <x-input wire:model="requested_pickup_date" wire:input="refreshPreview" type="date"
                    id="requested_pickup_date" name="requested_pickup_date"
                    class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs" />
            </div>
            <div>
                <x-label for="pickup_time" :value="__('Time')" class="text-xs" />
                <x-input wire:model="pickup_time" wire:input="refreshPreview" type="time" id="pickup_time"
                    name="pickup_time"
                    class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs" />
            </div>
            <div class="col-span-2">
                <x-label for="pickup_station" :value="__('Station (Pickup Location)')" class="text-xs" />
                <div class="flex items-center">
                    <select wire:model="pickup_station"
                        wire:change="updatePreview('pickup_station', $event.target.value)" id="pickup_station"
                        class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs">
                        <option value="">Select Station</option>
                        @foreach ($stations as $station) 
                            <option value="{{ $station->id }}">{{ $station->company }}</option>
                        @endforeach
                    </select>
                    <button wire:click.prevent="addStopOff('shipper')" type="button"
                        class="ml-2 px-2 py-1 bg-lime-500 text-white rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-red-500">
                        ADD
                    </button>
                </div>
                @foreach ($shipperStopOffs as $index => $stopOff)
                    <div class="flex items-center mt-3" wire:key="shipper-{{ $stopOff['id'] }}">
                        <select wire:change="updateStopOffStation('shipper', {{ $index }}, $event.target.value)"
                                class="block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs">
                            <option value="">Select Stop-off Station</option>
                            @foreach ($stations as $station)
                                <option value="{{ $station->id }}" {{ $stopOff['station_id'] == $station->id ? 'selected' : '' }}>
                                    {{ $station->company }}
                                </option>
                            @endforeach
                        </select>
                        <button wire:click.prevent="removeStopOff('shipper', '{{ $stopOff['id'] }}')" type="button"
                                class="ml-2 px-2 py-1 bg-red-500 text-white rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-red-500">
                            ×
                        </button>
                    </div>
                @endforeach
            </div>
            <!-- Stop-offs -->

            <div class="col-span-2">
                <x-label for="border_crossing_date" :value="__('Scheduled Border Crossing Date')" class="text-xs" />
                <x-input wire:model="border_crossing_date" wire:input="refreshPreview" type="date"
                    id="border_crossing_date" name="border_crossing_date"
                    class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs" />
            </div>
        </div>
    </div>

    <!-- Consignee Section -->
    <div class=" pl-2">
        <h2 class="text-red-500 font-bold mb-1">Consignee</h2>
        <hr class="mb-2">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-label for="delivery_date_requested" :value="__('Delivery Date Requested')" class="text-xs" />
                <x-input wire:model="delivery_date_requested" wire:input="refreshPreview" type="date"
                    id="delivery_date_requested" name="delivery_date_requested"
                    class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs" />
            </div>
            <div>
                <x-label for="delivery_time_requested" :value="__('Delivery Time Requested')" class="text-xs" />
                <x-input wire:model="delivery_time_requested" wire:input="refreshPreview" type="time"
                    id="delivery_time_requested" name="delivery_time_requested"
                    class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs" />
            </div>
            <div class="col-span-2">
                <x-label for="consignee_station" :value="__('Station (Delivery Location 1)')" class="text-xs" />
                <div class="flex items-center">
                    <select wire:model="consignee_station"
                        wire:change="updatePreview('consignee_station', $event.target.value)" id="consignee_station"
                        class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs">
                        <option value="">Select Station</option>
                        @foreach ($stations as $station)
                            <option value="{{ $station->id }}">{{ $station->company }}</option>
                        @endforeach
                    </select>

                    <button wire:click.prevent="addStopOff('consignee')" type="button"
                        class="ml-2 px-2 py-1 bg-lime-500 text-white rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-red-500">
                        ADD
                    </button>
                </div>
                @foreach ($consigneeStopOffs as $index => $stopOff)
                    <div class="flex items-center mt-3" wire:key="consignee-{{ $stopOff['id'] }}">
                        <select
                            wire:change="updateStopOffStation('consignee', {{ $index }}, $event.target.value)"
                            class="block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs">
                            <option value="">Select Stop-off Station</option>
                            @foreach ($stations as $station)
                                <option value="{{ $station->id }}" {{ $stopOff['station_id'] == $station->id ? 'selected' : '' }}>
                                    {{ $station->company }}
                                </option>
                            @endforeach
                        </select>
                        <button wire:click.prevent="removeStopOff('consignee', '{{ $stopOff['id'] }}')" type="button"
                            class="ml-2 px-2 py-1 bg-red-500 text-white rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-red-500">
                            ×
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>