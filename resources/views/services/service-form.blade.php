<div>
    <form method="POST" class="grid grid-cols-1 gap-4 p-2 md:grid-cols-2 lg:grid-cols-12">
        @csrf

        <div class="lg:col-span-7">
            @if ($service_detail_id != 7)
                <!-- Customer Info -->
                <livewire:customer-info :disable-pickup-no="$disablePickupNo" wire:model="customer" wire:model="shipment_status" />
            @endif



            <div class="grid grid-cols-1 gap-2 p-2 md:grid-cols-2 lg:grid-cols-12">
                <!-- Service Data-->
                <div class="mt-5 divisor md:col-span-12">
                    <h2 class="mb-1 font-bold text-red-500">Service
                        <span class="font-bold text-black">Data</span>
                    </h2>
                    <hr>
                </div>
                <div class="mt-2 md:col-span-3">
                    <x-label for="service_detail_id" :value="__('Select new shipment type')" class="text-xs" />
                    <select wire:model="service_detail_id" wire:change="refreshPreview" id="service_detail_id"
                        name="service_detail_id"
                        class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
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
                                class="text-green-500 rounded form-checkbox focus:ring-0">
                            <span class="text-gray-700">Expedited</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input wire:model="hazmat" wire:change="refreshPreview" type="checkbox"
                                class="text-green-500 rounded form-checkbox focus:ring-0">
                            <span class="text-gray-700">Hazmat</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input wire:model="team_driver" wire:change="refreshPreview" type="checkbox"
                                class="text-green-500 rounded form-checkbox focus:ring-0">
                            <span class="text-gray-700">Team Driver</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input wire:model="round_trip" wire:change="refreshPreview" type="checkbox"
                                class="text-green-500 rounded form-checkbox focus:ring-0">
                            <span class="text-gray-700">Round Trip</span>
                        </label>
                    </div>
                </div>
                <div class="mt-2 md:col-span-2">
                    <x-label for="un_number" :value="__('UN Number')" class="text-xs" />
                    <x-input wire:model="un_number" wire:input="refreshPreview" id="un_number" type="text"
                        name="un_number" placeholder="UN Num" class="block w-full mt-1" />
                </div>
                <!-- URGENCY LTL Section -->
                @php
                    $selectedService = $service_details->firstWhere('id', $service_detail_id);
                @endphp

                @if (
                    $selectedService &&
                        (str_contains($selectedService->name, 'LTL') || str_contains($selectedService->name, 'Air Freight')))
                    <div class="mt-2 md:col-span-12">
                        <h2 class="mb-1 font-bold text-red-500">Urgency LTL</h2>
                        <hr>
                    </div>
                    <div class="mt-2 md:col-span-3">
                        <x-label for="urgency_type" :value="__('Urgency Type')" class="text-xs" />
                        <select wire:model="urgency_type" wire:change="refreshPreview" id="urgency_type"
                            name="urgency_type"
                            class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
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
                            class="block w-full mt-1" />
                    </div>

                    <div class="mt-2 md:col-span-3">
                        <x-label for="company_id" :value="__('Company ID')" class="text-xs" />
                        <x-input wire:model="company_id" wire:input="refreshPreview" id="company_id" type="text"
                            name="company_id" placeholder="Enter Company ID" class="block w-full mt-1" />
                    </div>

                    <div class="mt-2 md:col-span-3">
                        <x-label for="phone" :value="__('Phone')" class="text-xs" />
                        <x-input wire:model="phone" wire:input="refreshPreview" id="phone" type="text"
                            name="phone" placeholder="Enter Phone Number" class="block w-full mt-1" />
                    </div>
                @endif

                @php
                    $selectedService = $service_details->firstWhere('id', $service_detail_id);
                @endphp

                @if ($selectedService && str_contains($selectedService->name, 'Container Drayage'))
                    <div class="mt-2 md:col-span-12">
                        <h2 class="mb-1 font-bold text-red-500">Container Drayage</h2>
                        <hr>
                    </div>

                    <!-- Modalidad -->
                    <div class="mt-2 md:col-span-3">
                        <x-label for="modality_type" :value="__('Modalidad')" class="text-xs" />
                        <select wire:model="modality_type" wire:change="refreshPreview" id="modality_type"
                            name="modality_type"
                            class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500">
                            <option value="">Select Modalidad</option>
                            <option value="single">Single</option>
                            <option value="full">Full</option>
                        </select>
                    </div>

                    <!-- Container -->
                    <div class="mt-2 md:col-span-3">
                        <x-label for="container" :value="__('Container')" class="text-xs" />
                        <x-input wire:model="container" wire:input="refreshPreview" id="container" type="text"
                            name="container" placeholder="Enter Container" class="block w-full mt-1" />
                    </div>

                    <!-- Size -->
                    <div class="mt-2 md:col-span-3">
                        <x-label for="size" :value="__('Size')" class="text-xs" />
                        <x-input wire:model="size" wire:input="refreshPreview" id="size" type="text"
                            name="size" placeholder="Enter Size" class="block w-full mt-1" />
                    </div>

                    <!-- Weight -->
                    <div class="mt-2 md:col-span-3">
                        <x-label for="modality_weight" :value="__('Weight')" class="text-xs" />
                        <x-input wire:model="modality_weight" wire:input="refreshPreview" id="modality_weight"
                            type="number" step="0.01" name="modality_weight" placeholder="Enter Weight"
                            class="block w-full mt-1" />
                    </div>

                    <!-- Unit of Measure -->
                    <div class="mt-2 md:col-span-3">
                        <x-label for="modality_uom" :value="__('Unit of Measure')" class="text-xs" />
                        <select wire:model="modality_uom" wire:change="refreshPreview" id="modality_uom"
                            name="modality_uom"
                            class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500">
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
                            class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500">
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
                    <div class="mt-5 divisor md:col-span-12">
                        <h2 class="mb-1 font-bold text-red-500">Cargo
                        </h2>
                        <hr>
                    </div>
                    <div class="mt-2 md:col-span-3">
                        <x-label for="handling_type" :value="__('Handling Type')" class="text-xs" />
                        <select wire:model="handling_type" wire:change="refreshPreview" id="handling_type"
                            name="handling_type"
                            class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
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
                            class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
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
                            class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500">
                            <option value="">Select Class</option>
                            @foreach ($freightClasses as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-2 md:col-span-2">
                        <x-label for="count" :value="__('Count')" class="text-xs" />
                        <x-input wire:model="count" wire:input="refreshPreview" id="count" type="number"
                            name="count" placeholder="Enter count" class="block w-full mt-1" />
                    </div>
                    <div class="mt-2 md:col-span-2">
                        <div x-data="{ on: @entangle('stackable') }" wire:change="refreshPreview"
                            class="flex items-center mt-6 space-x-2">
                            <div class="flex items-center">
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" x-model="on" class="sr-only">
                                        <div class="block w-12 h-5 bg-gray-300 rounded-full"
                                            :class="{ 'bg-green-600': on }"></div>
                                        <div class="absolute w-3 h-3 transition bg-white rounded-full dot left-1 top-1"
                                            :class="{ 'transform translate-x-6': on }"></div>
                                    </div>
                                    <span class="ml-3 text-xs font-medium text-gray-700">Stackable</span>
                                </label>
                            </div>
                            <span class="text-xs font-medium text-gray-700" x-text="on ? 'YES' : 'NO'"></span>
                        </div>
                    </div>
                    <!-- Weight -->
                    <div class="mt-2 md:col-span-2">
                        <x-label for="weight" :value="__('Weight')" class="text-xs" />
                        <x-input wire:model="weight" wire:input="refreshPreview" id="weight" type="number"
                            step="0.01" name="weight" placeholder="Enter weight" class="block w-full mt-1" />
                    </div>
                    <div class="mt-2 md:col-span-3">
                        <x-label for="uom_weight" :value="__('Weight Unit')" class="text-xs" />
                        <select wire:model="uom_weight" wire:change="refreshPreview" id="uom_weight"
                            name="uom_weight"
                            class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
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
                            step="0.01" name="length" placeholder="Enter length" class="block w-full mt-1" />
                    </div>
                    <!-- Width -->
                    <div class="mt-2 md:col-span-2">
                        <x-label for="width" :value="__('Width')" class="text-xs" />
                        <x-input wire:model="width" wire:input="refreshPreview" id="width" type="number"
                            step="0.01" name="width" placeholder="Enter width" class="block w-full mt-1" />
                    </div>
                    <!-- Height -->
                    <div class="mt-2 md:col-span-2">
                        <x-label for="height" :value="__('Height')" class="text-xs" />
                        <x-input wire:model="height" wire:input="refreshPreview" id="height" type="number"
                            step="0.01" name="height" placeholder="Enter height" class="block w-full mt-1" />
                    </div>
                    <div class="mt-2 md:col-span-3">
                        <x-label for="uom_dimensions" :value="__('Dimension Unit')" class="text-xs" />
                        <select wire:model="uom_dimensions" wire:change="refreshPreview" id="uom_dimensions"
                            name="uom_dimensions"
                            class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
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
                            class="block w-full mt-1" />
                    </div>
                @endif

                <div class="mt-5 mb-4 divisor md:col-span-12">
                    <hr>
                </div>

                <livewire:shipper-consignee-section :stations="$stations" :pickup_station="$pickup_station" :consignee_station="$consignee_station" />

                @if ($service_detail_id == 1)

                <!-- Sub services section -->
                <div class="mt-5 md:col-span-12">
                    <h2 class="mb-1 font-bold text-red-500">Sub <span class="font-bold text-black">Service</span></h2>
                    <hr>
                </div>
                <div class="mt-2 md:col-span-12">
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center space-x-2">
                            <input wire:model="sub_services.domestic_usa" type="checkbox"
                                   class="text-green-500 rounded form-checkbox focus:ring-0" id="mss1" onclick="main_sub_serv(1)">
                            <span class="text-gray-700">Domestic USA</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input wire:model="sub_services.domestic_mx" type="checkbox"
                                   class="text-green-500 rounded form-checkbox focus:ring-0" id="mss2" onclick="main_sub_serv(2)">
                            <span class="text-gray-700">Domestic MX</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input wire:model="sub_services.door_to_door_import" type="checkbox"
                                   class="text-green-500 rounded form-checkbox focus:ring-0" id="mss3" onclick="main_sub_serv(3)">
                            <span class="text-gray-700">Door to Door Import</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input wire:model="sub_services.door_to_door_export" type="checkbox"
                                   class="text-green-500 rounded form-checkbox focus:ring-0" id="mss4" onclick="main_sub_serv(4)">
                            <span class="text-gray-700">Door to Door Export</span>
                        </label>
                    </div>
                </div>
                <div class="mt-5 md:col-span-12" id="carr_cust_opts0" style="display: none;">
                    <h2 class="mb-1 font-bold text-red-500">Carrier/Customs Options</h2>
                    <hr>
                </div>
                <div class="mt-2 md:col-span-12" id="carr_cust_opts" style="display: none;">
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center space-x-2" id="l_c_o1">
                            <input wire:model="carrier_options.us_carrier" type="checkbox"
                                   class="text-green-500 rounded form-checkbox focus:ring-0" id="c_o1" onclick="sub_Service(1)">
                            <span class="text-gray-700">US Carrier</span>
                        </label>
                        <label class="flex items-center space-x-2" id="l_c_o2">
                            <input wire:model="carrier_options.us_customs_broker" type="checkbox"
                                   class="text-green-500 rounded form-checkbox focus:ring-0" id="c_o2" onclick="sub_Service(2)">
                            <span class="text-gray-700">US Customs Broker</span>
                        </label>
                        <label class="flex items-center space-x-2" id="l_c_o3">
                            <input wire:model="carrier_options.transfer" type="checkbox"
                                   class="text-green-500 rounded form-checkbox focus:ring-0" id="c_o3" onclick="sub_Service(3)">
                            <span class="text-gray-700">Transfer</span>
                        </label>
                        <label class="flex items-center space-x-2" id="l_c_o4">
                            <input wire:model="carrier_options.maneuvers" type="checkbox"
                                   class="text-green-500 rounded form-checkbox focus:ring-0" id="c_o4" onclick="sub_Service(4)">
                            <span class="text-gray-700">Maneuvers</span>
                        </label>
                        <label class="flex items-center space-x-2" id="l_c_o5">
                            <input wire:model="carrier_options.mx_carrier" type="checkbox"
                                   class="text-green-500 rounded form-checkbox focus:ring-0" id="c_o5" onclick="sub_Service(5)">
                            <span class="text-gray-700">Mx Carrier</span>
                        </label>
                    </div>
                </div>
                @endif
                <!--end sub services section -->
                <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
                <script type="text/javascript">
                    function sub_Service(dvm)
                    {
                        switch(dvm)
                        {
                            case 1:
                                const elemc = document.getElementById("c_o1");
                                const elemd = document.getElementById("sub_s1");
                                if(elemc.checked)
                                elemd.style.display = 'block'; else elemd.style.display = 'none';
                                break;
                            case 2:
                                const elemc2 = document.getElementById("c_o2");
                                const elemd2 = document.getElementById("bro_s1");
                                if(elemc2.checked)
                                elemd2.style.display = 'block'; else elemd2.style.display = 'none';
                                break;
                            case 3:
                                const elemc3 = document.getElementById("c_o3");
                                const elemd3 = document.getElementById("tra_s1");
                                if(elemc3.checked)
                                elemd3.style.display = 'block'; else elemd3.style.display = 'none';
                                break;
                            case 4:
                                const elemc4 = document.getElementById("c_o4");
                                const elemd4 = document.getElementById("man_s1");
                                if(elemc4.checked)
                                elemd4.style.display = 'block'; else elemd4.style.display = 'none';
                                break;
                            case 5:
                                const elemc5 = document.getElementById("c_o5");
                                const elemd5 = document.getElementById("mex_s1");
                                if(elemc5.checked)
                                elemd5.style.display = 'block'; else elemd5.style.display = 'none';
                                break;
                        }
                    }
                    function main_sub_serv(idv)
                    {
                        const dv0 = document.getElementById('carr_cust_opts0');
                        const dv1 = document.getElementById('carr_cust_opts');
                        const op1 = document.getElementById('mss1');
                        const op2 = document.getElementById('mss2');
                        const op3 = document.getElementById('mss3');
                        const op4 = document.getElementById('mss4');
                        const c_o1 = document.getElementById('c_o1');
                        const c_o2 = document.getElementById('c_o2');
                        const c_o3 = document.getElementById('c_o3');
                        const c_o4 = document.getElementById('c_o4');
                        const c_o5 = document.getElementById('c_o5');
                        var m = 0;
                        if(op1.checked) m++;
                        if(op2.checked) m++;
                        if(op3.checked) m++;
                        if(op4.checked) m++;
                        console.log(m);
                        if(m>0){
                            dv0.style.display = 'block';
                            dv1.style.display = 'block';
                        }
                        else{
                            dv0.style.display = 'none';
                            dv1.style.display = 'none';
                        }
                        switch(idv)
                        {
                            case 1:
                                c_o1.style.display = 'block';
                                c_o2.style.display = 'block';
                                c_o3.style.display = 'none';
                                c_o4.style.display = 'block';
                                c_o5.style.display = 'none';
                                l_c_o1.style.display = 'inherit';
                                l_c_o2.style.display = 'inherit';
                                l_c_o3.style.display = 'none';
                                l_c_o4.style.display = 'inherit';
                                l_c_o5.style.display = 'none';
                                c_o1.checked = false;
                                c_o2.checked = false;
                                c_o3.checked = false;
                                c_o4.checked = false;
                                c_o5.checked = false;

                                op2.checked = false;
                                op3.checked = false;
                                op4.checked = false;
                                break;
                            case 2:
                                c_o1.style.display = 'none';
                                c_o2.style.display = 'none';
                                c_o3.style.display = 'block';
                                c_o4.style.display = 'none';
                                c_o5.style.display = 'block';
                                l_c_o1.style.display = 'none';
                                l_c_o2.style.display = 'none';
                                l_c_o3.style.display = 'inherit';
                                l_c_o4.style.display = 'none';
                                l_c_o5.style.display = 'inherit';
                                c_o1.checked = false;
                                c_o2.checked = false;
                                c_o3.checked = false;
                                c_o4.checked = false;
                                c_o5.checked = false;
                                op1.checked = false;
                                op3.checked = false;
                                op4.checked = false;
                                break;
                            case 3:
                                c_o1.style.display = 'block';
                                c_o2.style.display = 'block';
                                c_o3.style.display = 'block';
                                c_o4.style.display = 'block';
                                c_o5.style.display = 'block';
                                l_c_o1.style.display = 'inherit';
                                l_c_o2.style.display = 'inherit';
                                l_c_o3.style.display = 'inherit';
                                l_c_o4.style.display = 'inherit';
                                l_c_o5.style.display = 'inherit';
                                c_o1.checked = false;
                                c_o2.checked = false;
                                c_o3.checked = false;
                                c_o4.checked = false;
                                c_o5.checked = false;
                                op2.checked = false;
                                op1.checked = false;
                                op4.checked = false;
                                break;
                            case 4:
                                c_o1.style.display = 'block';
                                c_o2.style.display = 'block';
                                c_o3.style.display = 'block';
                                c_o4.style.display = 'block';
                                c_o5.style.display = 'block';
                                l_c_o1.style.display = 'inherit';
                                l_c_o2.style.display = 'inherit';
                                l_c_o3.style.display = 'inherit';
                                l_c_o4.style.display = 'inherit';
                                l_c_o5.style.display = 'inherit';
                                c_o1.checked = false;
                                c_o2.checked = false;
                                c_o3.checked = false;
                                c_o4.checked = false;
                                c_o5.checked = false;
                                op2.checked = false;
                                op3.checked = false;
                                op1.checked = false;
                                break;
                        }
                    }
                    async function fill_equip()
                    {
                        var sup_id = document.getElementById("sup_id").value;
                        if(sup_id > 0)
                        {
                            var data;
                            await $.ajax({
                                type: 'GET',
                                url: '/datamodel/equipment?sup_id=' + sup_id,
                                success: function(response){
                                    data = response;
                                }
                            });
                            console.log(data.length);
                            if(data.length > 0)
                            {
                                const sel = document.getElementById("sup_equ");
                                sel.disabled = false;
                                data.forEach(item => {
                                    var opt = document.createElement('option');
                                    opt.value = item.id;
                                    opt.innerHTML = item.equipment;
                                    sel.appendChild(opt);
                                });
                            }
                        }
                    }
                    async function fill_equip2()
                    {
                        var sup_id = document.getElementById("mex_id").value;
                        if(sup_id > 0)
                        {
                            var data;
                            await $.ajax({
                                type: 'GET',
                                url: '/datamodel/equipment?sup_id=' + sup_id,
                                success: function(response){
                                    data = response;
                                }
                            });
                            console.log(data.length);
                            if(data.length > 0)
                            {
                                const sel = document.getElementById("mex_equ");
                                sel.disabled = false;
                                data.forEach(item => {
                                    var opt = document.createElement('option');
                                    opt.value = item.id;
                                    opt.innerHTML = item.equipment;
                                    sel.appendChild(opt);
                                });
                            }
                        }
                    }
                </script>

                    <?php include(resource_path("views/services/components/views/uscarrier.blade.php"))?>
                    <?php include(resource_path("views/services/components/views/usbroker.blade.php"))?>
                    <?php include(resource_path("views/services/components/views/transfer.blade.php"))?>
                    <?php include(resource_path("views/services/components/views/maneuvers.blade.php"))?>
                    <?php include(resource_path("views/services/components/views/mxcarrier.blade.php"))?>

            </div>
        </div>

        <!-- Preview -->
        <div class="lg:col-span-5">
            <x-label :value="__('Review')" class="font-bold" />
            <div class="p-4 border">
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
                <h3 class="mt-4 font-bold text-red-500">{{ __('Shipper Info') }}</h3>
                <p class="text-xs"><strong>{{ __('Requested Pickup Date:') }}</strong>
                    {{ $requested_pickup_date ?? 'N/A' }}</p>
                <p class="text-xs"><strong>{{ __('Time:') }}</strong> {{ $pickup_time ?? 'N/A' }}</p>
                <p class="text-xs"><strong>{{ __('Station (Pickup Location):') }}</strong>
                    {{ $stations->firstWhere('id', $pickup_station)?->company ?? 'N/A' }}</p>
                <p class="text-xs"><strong>{{ __('Scheduled Border Crossing Date:') }}</strong>
                    {{ $border_crossing_date ?? 'N/A' }}
                </p>
                <h4 class="mt-2 text-xs font-bold">{{ __('Stop-offs:') }}</h4>
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
                <h3 class="mt-4 font-bold text-red-500">{{ __('Consignee Info') }}</h3>
                <p class="text-xs"><strong>{{ __('Delivery Date Requested:') }}</strong>
                    {{ $delivery_date_requested ?? 'N/A' }}</p>
                <p class="text-xs"><strong>{{ __('Delivery Time Requested:') }}</strong>
                    {{ $delivery_time_requested ?? 'N/A' }}</p>
                <p class="text-xs"><strong>{{ __('Station (Delivery Location 1):') }}</strong>
                    {{ $stations->firstWhere('id', $consignee_station)?->company ?? 'N/A' }}</p>
                <h4 class="mt-2 text-xs font-bold">{{ __('Stop-offs:') }}</h4>
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

        <div class="mt-4 lg:col-span-5">
            <button wire:click="saveService" type="button"
                class="px-4 py-2 text-white bg-blue-500 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 hover:bg-blue-600 disabled:bg-gray-400 disabled:cursor-not-allowed"
                wire:loading.attr="disabled" wire:target="saveService" :disabled="$isSaving">
                Save Service
            </button>
            <span wire:loading wire:target="saveService" class="text-sm text-gray-500">
                Saving...
            </span>
            @if (session()->has('message'))
                <div class="p-2 text-green-700 bg-green-200 rounded-md">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="p-2 text-red-700 bg-red-200 rounded-md">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </form>
</div>
