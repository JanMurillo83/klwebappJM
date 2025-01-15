<div>
    <form method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-4 p-2">
        @csrf

        <div class="lg:col-span-7">
            @if ($service_detail_id != 7)
                <!-- Customer Info -->
                <livewire:customer-info :disable-pickup-no="$disablePickupNo" wire:model="customer" wire:model="shipment_status" />
            @endif



            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-2 p-2">
                <!-- Service Data-->
                <div class="divisor mt-5 md:col-span-12">
                    <h2 class="text-red-500  font-bold mb-1">Service
                        <span class="text-black font-bold">Data</span>
                    </h2>
                    <hr>
                </div>
                <div class="mt-2 md:col-span-3">
                    <x-label for="service_detail_id" :value="__('Select new shipment type')" class="text-xs" />
                    <select wire:model="service_detail_id" wire:change="refreshPreview" id="service_detail_id"
                        name="service_detail_id"
                        class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs text-gray-800 placeholder:text-gray-400">
                        <option value="">Select Service Type</option>
                        @foreach ($service_details as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-8 ml-3 md:col-span-6">
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center space-x-2">
                            <input wire:model="expedited" wire:change="refreshPreview" type="checkbox"
                                class="form-checkbox text-green-500 rounded focus:ring-0">
                            <span class="text-gray-700">Expedited</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input wire:model="hazmat" wire:change="refreshPreview" type="checkbox"
                                class="form-checkbox text-green-500 rounded focus:ring-0">
                            <span class="text-gray-700">Hazmat</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input wire:model="team_driver" wire:change="refreshPreview" type="checkbox"
                                class="form-checkbox text-green-500 rounded focus:ring-0">
                            <span class="text-gray-700">Team Driver</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input wire:model="round_trip" wire:change="refreshPreview" type="checkbox"
                                class="form-checkbox text-green-500 rounded focus:ring-0">
                            <span class="text-gray-700">Round Trip</span>
                        </label>
                    </div>
                </div>
                <div class="mt-2 md:col-span-2">
                    <x-label for="un_number" :value="__('UN Number')" class="text-xs" />
                    <x-input wire:model="un_number" wire:input="refreshPreview" id="un_number" type="text"
                        name="un_number" placeholder="UN Num" class="block mt-1 w-full" />
                </div>
                <!-- URGENCY LTL Section -->
                @php
                    $selectedService = $service_details->firstWhere('id', $service_detail_id);
                @endphp

                @if (
                    $selectedService &&
                        (str_contains($selectedService->name, 'LTL') || str_contains($selectedService->name, 'Air Freight')))
                    <div class="mt-2 md:col-span-12">
                        <h2 class="text-red-500 font-bold mb-1">Urgency LTL</h2>
                        <hr>
                    </div>
                    <div class="mt-2 md:col-span-3">
                        <x-label for="urgency_type" :value="__('Urgency Type')" class="text-xs" />
                        <select wire:model="urgency_type" wire:change="refreshPreview" id="urgency_type"
                            name="urgency_type"
                            class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs text-gray-800 placeholder:text-gray-400">
                            <option value="">Select Urgency Type</option>
                            @foreach ($urgency_types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-2 md:col-span-3">
                        <x-label for="emergency_company" :value="__('Emergency Company')" class="text-xs" />
                        <x-input wire:model="emergency_company" wire:input="refreshPreview" id="emergency_company"
                            type="text" name="emergency_company" placeholder="Enter Emergency Company"
                            class="block mt-1 w-full" />
                    </div>

                    <div class="mt-2 md:col-span-3">
                        <x-label for="company_id" :value="__('Company ID')" class="text-xs" />
                        <x-input wire:model="company_id" wire:input="refreshPreview" id="company_id" type="text"
                            name="company_id" placeholder="Enter Company ID" class="block mt-1 w-full" />
                    </div>

                    <div class="mt-2 md:col-span-3">
                        <x-label for="phone" :value="__('Phone')" class="text-xs" />
                        <x-input wire:model="phone" wire:input="refreshPreview" id="phone" type="text"
                            name="phone" placeholder="Enter Phone Number" class="block mt-1 w-full" />
                    </div>
                @endif

                @php
                    $selectedService = $service_details->firstWhere('id', $service_detail_id);
                @endphp

                @if ($selectedService && str_contains($selectedService->name, 'Container Drayage'))
                    <div class="mt-2 md:col-span-12">
                        <h2 class="text-red-500 font-bold mb-1">Container Drayage</h2>
                        <hr>
                    </div>

                    <!-- Modalidad -->
                    <div class="mt-2 md:col-span-3">
                        <x-label for="modality_type" :value="__('Modalidad')" class="text-xs" />
                        <select wire:model="modality_type" wire:change="refreshPreview" id="modality_type"
                            name="modality_type"
                            class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs text-gray-800">
                            <option value="">Select Modalidad</option>
                            <option value="single">Single</option>
                            <option value="full">Full</option>
                        </select>
                    </div>

                    <!-- Container -->
                    <div class="mt-2 md:col-span-3">
                        <x-label for="container" :value="__('Container')" class="text-xs" />
                        <x-input wire:model="container" wire:input="refreshPreview" id="container" type="text"
                            name="container" placeholder="Enter Container" class="block mt-1 w-full" />
                    </div>

                    <!-- Size -->
                    <div class="mt-2 md:col-span-3">
                        <x-label for="size" :value="__('Size')" class="text-xs" />
                        <x-input wire:model="size" wire:input="refreshPreview" id="size" type="text"
                            name="size" placeholder="Enter Size" class="block mt-1 w-full" />
                    </div>

                    <!-- Weight -->
                    <div class="mt-2 md:col-span-3">
                        <x-label for="modality_weight" :value="__('Weight')" class="text-xs" />
                        <x-input wire:model="modality_weight" wire:input="refreshPreview" id="modality_weight"
                            type="number" step="0.01" name="modality_weight" placeholder="Enter Weight"
                            class="block mt-1 w-full" />
                    </div>

                    <!-- Unit of Measure -->
                    <div class="mt-2 md:col-span-3">
                        <x-label for="modality_uom" :value="__('Unit of Measure')" class="text-xs" />
                        <select wire:model="modality_uom" wire:change="refreshPreview" id="modality_uom"
                            name="modality_uom"
                            class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs text-gray-800">
                            <option value="">Select UOM</option>
                            @foreach ($uom_weight_options as $option)
                                <option value="{{ $option->id }}">{{ $option->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Material Type -->
                    <div class="mt-2 md:col-span-3">
                        <x-label for="modality_material_type" :value="__('Material Type')" class="text-xs" />
                        <select wire:model="modality_material_type" wire:change="refreshPreview"
                            id="modality_material_type" name="modality_material_type"
                            class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs text-gray-800">
                            <option value="">Select Material Type</option>
                            @foreach ($materialTypes as $material)
                                <option value="{{ $material->id }}">{{ $material->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif



                <!-- Service Cargo -->
                @if (
                    $selectedService &&
                        !in_array($selectedService->name, ['Container Drayage', 'Trailer Rental', 'Us Customs Broker', 'Transfer']))
                    <div class="divisor mt-5 md:col-span-12">
                        <h2 class="text-red-500  font-bold mb-1">Cargo
                        </h2>
                        <hr>
                    </div>
                    <div class="mt-2 md:col-span-3">
                        <x-label for="handling_type" :value="__('Handling Type')" class="text-xs" />
                        <select wire:model="handling_type" wire:change="refreshPreview" id="handling_type"
                            name="handling_type"
                            class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs text-gray-800 placeholder:text-gray-400">
                            <option value="">Select Handling</option>
                            @foreach ($handling_types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-2 md:col-span-3">
                        <x-label for="material_type" :value="__('Material Type')" class="text-xs" />
                        <select wire:model="material_type" wire:change="refreshPreview" id="material_type"
                            name="material_type"
                            class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs text-gray-800 placeholder:text-gray-400">
                            <option value="">Select Material</option>
                            @foreach ($materialTypes as $material)
                                <option value="{{ $material->id }}">{{ $material->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-2 md:col-span-2">
                        <x-label for="freight_class" :value="__('Class')" class="text-xs" />
                        <select wire:model="freight_class" wire:change="refreshPreview" id="freight_class"
                            name="freight_class"
                            class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs text-gray-800">
                            <option value="">Select Class</option>
                            @foreach ($freightClasses as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-2 md:col-span-2">
                        <x-label for="count" :value="__('Count')" class="text-xs" />
                        <x-input wire:model="count" wire:input="refreshPreview" id="count" type="number"
                            name="count" placeholder="Enter count" class="block mt-1 w-full" />
                    </div>
                    <div class="mt-2 md:col-span-2">
                        <div x-data="{ on: @entangle('stackable') }" wire:change="refreshPreview"
                            class="mt-6 flex items-center space-x-2">
                            <div class="flex items-center">
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" x-model="on" class="sr-only">
                                        <div class="block bg-gray-300 w-12 h-5 rounded-full"
                                            :class="{ 'bg-green-600': on }"></div>
                                        <div class="dot absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition"
                                            :class="{ 'transform translate-x-6': on }"></div>
                                    </div>
                                    <span class="ml-3 text-gray-700 font-medium text-xs">Stackable</span>
                                </label>
                            </div>
                            <span class="text-gray-700 font-medium text-xs" x-text="on ? 'YES' : 'NO'"></span>
                        </div>
                    </div>
                    <!-- Weight -->
                    <div class="mt-2 md:col-span-2">
                        <x-label for="weight" :value="__('Weight')" class="text-xs" />
                        <x-input wire:model="weight" wire:input="refreshPreview" id="weight" type="number"
                            step="0.01" name="weight" placeholder="Enter weight" class="block mt-1 w-full" />
                    </div>
                    <div class="mt-2 md:col-span-3">
                        <x-label for="uom_weight" :value="__('Weight Unit')" class="text-xs" />
                        <select wire:model="uom_weight" wire:change="refreshPreview" id="uom_weight"
                            name="uom_weight"
                            class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs text-gray-800 placeholder:text-gray-400">
                            <option value="">Select Weight Unit</option>
                            @foreach ($uom_weight_options as $option)
                                <option value="{{ $option->id }}">{{ $option->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Length -->
                    <div class="mt-2 md:col-span-2">
                        <x-label for="length" :value="__('Length')" class="text-xs" />
                        <x-input wire:model="length" wire:input="refreshPreview" id="length" type="number"
                            step="0.01" name="length" placeholder="Enter length" class="block mt-1 w-full" />
                    </div>
                    <!-- Width -->
                    <div class="mt-2 md:col-span-2">
                        <x-label for="width" :value="__('Width')" class="text-xs" />
                        <x-input wire:model="width" wire:input="refreshPreview" id="width" type="number"
                            step="0.01" name="width" placeholder="Enter width" class="block mt-1 w-full" />
                    </div>
                    <!-- Height -->
                    <div class="mt-2 md:col-span-2">
                        <x-label for="height" :value="__('Height')" class="text-xs" />
                        <x-input wire:model="height" wire:input="refreshPreview" id="height" type="number"
                            step="0.01" name="height" placeholder="Enter height" class="block mt-1 w-full" />
                    </div>
                    <div class="mt-2 md:col-span-3">
                        <x-label for="uom_dimensions" :value="__('Dimension Unit')" class="text-xs" />
                        <select wire:model="uom_dimensions" wire:change="refreshPreview" id="uom_dimensions"
                            name="uom_dimensions"
                            class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs text-gray-800 placeholder:text-gray-400">
                            <option value="">Select Dimension Unit</option>
                            @foreach ($uom_dimensions_options as $option)
                                <option value="{{ $option->id }}">{{ $option->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Total Yards -->
                    <div class="mt-2 md:col-span-2">
                        <x-label for="total_yards" :value="__('Total Yards')" class="text-xs" />
                        <x-input wire:model="total_yards" wire:input="refreshPreview" id="total_yards"
                            type="number" step="0.01" name="total_yards" placeholder="Enter total yards"
                            class="block mt-1 w-full" />
                    </div>
                @endif

                <div class="divisor mt-5 mb-4 md:col-span-12">
                    <hr>
                </div>

                <livewire:shipper-consignee-section :stations="$stations" :pickup_station="$pickup_station" :consignee_station="$consignee_station" />

                @if ($service_detail_id == 1)

                <!-- Sub services section -->
                <div class="mt-5 md:col-span-12">
                    <h2 class="text-red-500 font-bold mb-1">Sub <span class="text-black font-bold">Service</span></h2>
                    <hr>
                </div>
                <div class="mt-2 md:col-span-12">
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center space-x-2">
                            <input wire:model="sub_services.domestic_usa" type="checkbox" 
                                   class="form-checkbox text-green-500 rounded focus:ring-0">
                            <span class="text-gray-700">Domestic USA</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input wire:model="sub_services.domestic_mx" type="checkbox" 
                                   class="form-checkbox text-green-500 rounded focus:ring-0">
                            <span class="text-gray-700">Domestic MX</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input wire:model="sub_services.door_to_door_import" type="checkbox" 
                                   class="form-checkbox text-green-500 rounded focus:ring-0">
                            <span class="text-gray-700">Door to Door Import</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input wire:model="sub_services.door_to_door_export" type="checkbox" 
                                   class="form-checkbox text-green-500 rounded focus:ring-0">
                            <span class="text-gray-700">Door to Door Export</span>
                        </label>
                    </div>
                </div>
                <div class="mt-5 md:col-span-12">
                    <h2 class="text-red-500 font-bold mb-1">Carrier/Customs Options</h2>
                    <hr>
                </div>
                <div class="mt-2 md:col-span-12">
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center space-x-2">
                            <input wire:model="carrier_options.us_carrier" type="checkbox"
                                   class="form-checkbox text-green-500 rounded focus:ring-0">
                            <span class="text-gray-700">US Carrier</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input wire:model="carrier_options.us_customs_broker" type="checkbox"
                                   class="form-checkbox text-green-500 rounded focus:ring-0">
                            <span class="text-gray-700">US Customs Broker</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input wire:model="carrier_options.transfer" type="checkbox"
                                   class="form-checkbox text-green-500 rounded focus:ring-0">
                            <span class="text-gray-700">Transfer</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input wire:model="carrier_options.maneuvers" type="checkbox"
                                   class="form-checkbox text-green-500 rounded focus:ring-0">
                            <span class="text-gray-700">Maneuvers</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input wire:model="carrier_options.mx_carrier" type="checkbox"
                                   class="form-checkbox text-green-500 rounded focus:ring-0">
                            <span class="text-gray-700">Mx Carrier</span>
                        </label>
                    </div>
                </div>
                
                @endif
                <!--end sub services section -->
            </div>
        </div>

        <!-- Preview -->
        <div class="lg:col-span-5">
            <x-label :value="__('Review')" class="font-bold" />
            <div class="border p-4">
                @if ($service_detail_id != 7)
                    <p class="text-xs"><strong>{{ __('Customer:') }}</strong>
                        {{ $selectedCustomer?->company ?? 'N/A' }}
                    </p>
                    <p class="text-xs"><strong>{{ __('Rate to Customer:') }}</strong>
                        {{ $rate_to_customer ?? 'N/A' }}
                    </p>
                    <p class="text-xs"><strong>{{ __('Currency:') }}</strong> {{ $currency ?? 'N/A' }}</p>
                    <p class="text-xs"><strong>{{ __('Billing Ref:') }}</strong>
                        {{ $billing_currency_reference ?? 'N/A' }}</p>
                @endif
                @if (
                    $selectedService &&
                        !in_array($selectedService->name, [
                            'Container Drayage',
                            'Trailer Rental',
                            'Warehouse',
                            'Us Customs Broker',
                            'Transfer',
                        ]))
                    <p class="text-xs"><strong>{{ __('Pickup No.:') }}</strong> {{ $pickup_number ?? 'N/A' }}</p>
                @endif
                <p class="text-xs"><strong>{{ __('Shipment Status:') }}</strong>
                    {{ $selectedShipmentStatus?->name ?? 'N/A' }}</p>
                <p class="text-xs"><strong>{{ __('Shipment Type:') }}</strong>
                    {{ $service_details->firstWhere('id', $service_detail_id)?->name ?? 'N/A' }}</p>
                <p class="text-xs"><strong>{{ __('Expedited:') }}</strong> {{ $expedited ? 'Yes' : 'No' }}</p>
                <p class="text-xs"><strong>{{ __('Hazmat:') }}</strong> {{ $hazmat ? 'Yes' : 'No' }}</p>
                <p class="text-xs"><strong>{{ __('Team Driver:') }}</strong> {{ $team_driver ? 'Yes' : 'No' }}</p>
                <p class="text-xs"><strong>{{ __('Round Trip:') }}</strong> {{ $round_trip ? 'Yes' : 'No' }}</p>
                <p class="text-xs"><strong>{{ __('UN Number:') }}</strong> {{ $un_number ?? 'N/A' }}</p>
                @if (
                    $selectedService &&
                        (str_contains($selectedService->name, 'LTL') || str_contains($selectedService->name, 'Air Freight')))
                    <p class="text-xs"><strong>{{ __('Urgency Type:') }}</strong>
                        {{ $urgency_types->firstWhere('id', $urgency_type)?->name ?? 'N/A' }}
                    </p>
                    <p class="text-xs"><strong>{{ __('Emergency Company:') }}</strong>
                        {{ $emergency_company ?? 'N/A' }}
                    </p>
                    <p class="text-xs"><strong>{{ __('Company ID:') }}</strong>
                        {{ $company_id ?? 'N/A' }}
                    </p>
                    <p class="text-xs"><strong>{{ __('Phone:') }}</strong>
                        {{ $phone ?? 'N/A' }}
                    </p>
                @endif
                @if ($selectedService && str_contains($selectedService->name, 'Container Drayage'))
                    <div class="mt-4">
                        <h3 class="font-bold text-red-500">{{ __('Container Drayage Info') }}</h3>
                        <p class="text-xs"><strong>{{ __('Modalidad:') }}</strong> {{ $modality_type ?? 'N/A' }}</p>
                        <p class="text-xs"><strong>{{ __('Container:') }}</strong> {{ $container ?? 'N/A' }}</p>
                        <p class="text-xs"><strong>{{ __('Size:') }}</strong> {{ $size ?? 'N/A' }}</p>
                        <p class="text-xs"><strong>{{ __('Weight:') }}</strong> {{ $modality_weight ?? 'N/A' }}
                            {{ $uom_weight_options->firstWhere('id', $modality_uom)?->name ?? '--' }}</p>
                        <p class="text-xs"><strong>{{ __('Material Type:') }}</strong>
                            {{ $materialTypes->firstWhere('id', $modality_material_type)?->name ?? 'N/A' }}</p>
                    </div>
                @endif

                @if (
                    $selectedService &&
                        !in_array($selectedService->name, ['Container Drayage', 'Trailer Rental', 'Us Customs Broker', 'Transfer']))
                    <p class="text-xs"><strong>{{ __('Handling Type:') }}</strong>
                        {{ $handling_types->firstWhere('id', $handling_type)?->name ?? 'N/A' }}</p>
                    <p class="text-xs"><strong>{{ __('Material Type:') }}</strong>
                        {{ $materialTypes->firstWhere('id', $material_type)?->name ?? 'N/A' }}</p>
                    <p class="text-xs"><strong>{{ __('Class:') }}</strong>
                        {{ $freight_class ? $freightClasses->firstWhere('id', $freight_class)?->name : 'N/A' }}</p>
                    <p class="text-xs"><strong>{{ __('Count:') }}</strong> {{ $count ?? 'N/A' }}</p>
                    <p class="text-xs"><strong>{{ __('Stackable:') }}</strong> {{ $stackable ? 'YES' : 'NO' }}</p>
                    <p class="text-xs"><strong>{{ __('Weight:') }}</strong> {{ $weight ?? 'N/A' }}
                        {{ $uom_weight_options->firstWhere('id', $uom_weight)?->name ?? '--' }}</p>
                    <p class="text-xs"><strong>{{ __('Length:') }}</strong> {{ $length ?? 'N/A' }}
                        {{ $uom_dimensions_options->firstWhere('id', $uom_dimensions)?->name ?? '--' }}</p>
                    <p class="text-xs"><strong>{{ __('Width:') }}</strong> {{ $width ?? 'N/A' }}
                        {{ $uom_dimensions_options->firstWhere('id', $uom_dimensions)?->name ?? '--' }}</p>
                    <p class="text-xs"><strong>{{ __('Height:') }}</strong> {{ $height ?? 'N/A' }}
                        {{ $uom_dimensions_options->firstWhere('id', $uom_dimensions)?->name ?? '--' }}</p>
                    <p class="text-xs"><strong>{{ __('Total Yards:') }}</strong> {{ $total_yards ?? 'N/A' }}</p>
                @endif

                <!-- Shipper Data -->
                <h3 class="font-bold text-red-500 mt-4">{{ __('Shipper Info') }}</h3>
                <p class="text-xs"><strong>{{ __('Requested Pickup Date:') }}</strong>
                    {{ $requested_pickup_date ?? 'N/A' }}</p>
                <p class="text-xs"><strong>{{ __('Time:') }}</strong> {{ $pickup_time ?? 'N/A' }}</p>
                <p class="text-xs"><strong>{{ __('Station (Pickup Location):') }}</strong>
                    {{ $stations->firstWhere('id', $pickup_station)?->company ?? 'N/A' }}</p>
                <p class="text-xs"><strong>{{ __('Scheduled Border Crossing Date:') }}</strong>
                    {{ $border_crossing_date ?? 'N/A' }}
                </p>
                <h4 class="font-bold mt-2 text-xs">{{ __('Stop-offs:') }}</h4>
                <ul>
                    @forelse ($shipperStopOffs as $stopOff)
                        <li class="text-xs">
                            {{ $stations->firstWhere('id', $stopOff['station_id'])?->company ?? 'N/A' }}
                        </li>
                    @empty
                        <li class="text-xs">{{ __('No Stop-offs Added') }}</li>
                    @endforelse
                </ul>

                <!-- Consignee Data -->
                <h3 class="font-bold text-red-500 mt-4">{{ __('Consignee Info') }}</h3>
                <p class="text-xs"><strong>{{ __('Delivery Date Requested:') }}</strong>
                    {{ $delivery_date_requested ?? 'N/A' }}</p>
                <p class="text-xs"><strong>{{ __('Delivery Time Requested:') }}</strong>
                    {{ $delivery_time_requested ?? 'N/A' }}</p>
                <p class="text-xs"><strong>{{ __('Station (Delivery Location 1):') }}</strong>
                    {{ $stations->firstWhere('id', $consignee_station)?->company ?? 'N/A' }}</p>
                <h4 class="font-bold mt-2 text-xs">{{ __('Stop-offs:') }}</h4>
                <ul>
                    @forelse ($consigneeStopOffs as $stopOff)
                        <li class="text-xs">
                            {{ $stations->firstWhere('id', $stopOff['station_id'])?->company ?? 'N/A' }}
                        </li>
                    @empty
                        <li class="text-xs">{{ __('No Stop-offs Added') }}</li>
                    @endforelse
                </ul>


            </div>
        </div>

        <div class="lg:col-span-5 mt-4">
            <button wire:click="saveService" type="button"
                class="px-4 py-2 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500
           bg-blue-500 hover:bg-blue-600
           disabled:bg-gray-400 disabled:cursor-not-allowed"
                wire:loading.attr="disabled" wire:target="saveService" :disabled="$isSaving">
                Save Service
            </button>
            <span wire:loading wire:target="saveService" class="text-sm text-gray-500">
                Saving...
            </span>
            @if (session()->has('message'))
                <div class="p-2 bg-green-200 text-green-700 rounded-md">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="p-2 bg-red-200 text-red-700 rounded-md">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </form>
</div>
