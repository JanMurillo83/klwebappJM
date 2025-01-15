<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <h2 class="text-xl font-semibold mb-4">Add New {{ ucfirst($type) }}</h2>
        </h2>
    </x-slot>
    <div class="ms-12 me-12">
        <form action="{{ route('business-directory.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            <div class="flex flex-wrap">
                <!-- Left Column -->
                <div class="w-full lg:w-10/12 flex flex-wrap">
                    <!-- Row 1 -->
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-3/12 p-1">
                        <input type="hidden" name="type" value="{{ $type }}">
                        <x-label for="company" value="{{ __('Company') }}" />
                        <x-input id="company" placeholder="Customer Company" type="text" name="company"
                            class="mt-1 block w-full" required />
                        @error('company')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-2/12 p-1">
                        <x-label for="nickname" value="{{ __('Nickname') }}" />
                        <x-input id="nickname" placeholder="Placeholder" type="text" name="nickname"
                            class="mt-1 block w-full" />
                        @error('nickname')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/12 p-1">
                        <x-label for="billing_currency" value="{{ __('B. Currency') }}" />
                        <select id="billing_currency" name="billing_currency"
                            class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs text-gray-800 placeholder:text-gray-400">
                            <option value="MXN">MXN</option>
                            <option value="USD">USD</option>
                        </select>
                    </div>
                    <!-- Row 2 -->
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-2/12 p-1">
                        <x-label for="rfc_tax_id" value="{{ __('RFC') }}" />
                        <x-input id="rfc_tax_id" placeholder="Tax ID" type="text" name="rfc_tax_id"
                            class="mt-1 block w-full" />
                        @error('rfc_tax_id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-3/12 p-1">
                        <x-label for="street_address" value="{{ __('Street Address') }}" />
                        <x-input id="street_address" placeholder="Placeholder" type="text" name="street_address"
                            class="mt-1 block w-full" />
                        @error('street_address')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/12 p-1">
                        <x-label for="building_number" value="{{ __('Building #') }}" />
                        <x-input id="building_number" placeholder="Placeholder" type="text" name="building_number"
                            class="mt-1 block w-full" />
                        @error('building_number')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Row 3 -->
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-4/12 p-1">
                        <x-label for="neighborhood" value="{{ __('Neighborhood') }}" />
                        <x-input id="neighborhood" placeholder="Placeholder" type="text" name="neighborhood"
                            class="mt-1 block w-full" />
                        @error('neighborhood')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-3/12 p-1">
                        <x-label for="city" value="{{ __('City') }}" />
                        <x-input id="city" placeholder="Placeholder" type="text" name="city"
                            class="mt-1 block w-full" />
                        @error('city')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-2/12 p-1">
                        <x-label for="state" value="{{ __('State') }}" />
                        <x-input id="state" placeholder="Placeholder" type="text" name="state"
                            class="mt-1 block w-full" />
                        @error('state')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Row 4 -->
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/12 p-1">
                        <x-label for="postal_code" value="{{ __('Postal Code') }}" />
                        <x-input id="postal_code" placeholder="Placeholder" type="text" name="postal_code"
                            class="mt-1 block w-full" />
                        @error('postal_code')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-2/12 p-1">
                        <x-label for="country" value="{{ __('Country') }}" />
                        <x-input id="country" placeholder="Placeholder" type="text" name="country"
                            class="mt-1 block w-full" />
                        @error('country')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/6 p-1">
                        <x-label for="phone" value="{{ __('Phone') }}" />
                        <x-input id="phone" placeholder="Placeholder" type="text" name="phone"
                            class="mt-1 block w-full" />
                        @error('phone')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Row 5 -->
                    <div class="w-full md:w-1/2 p-1">
                        <x-label for="website" value="{{ __('Website') }}" />
                        <x-input id="website" placeholder="Placeholder" type="url" name="website"
                            class="mt-1 block w-full" />
                        @error('website')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/3 p-1">
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" placeholder="Placeholder" type="email" name="email"
                            class="mt-1 block w-full" />
                        @error('email')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/6 p-1">
                        <x-label for="credit_days" value="{{ __('Credit Days') }}" />
                        <x-input id="credit_days" placeholder="Credit Days" type="text" name="credit_days"
                            class="mt-1 block w-full" />
                        @error('credit_days')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/6 p-1">
                        <label for="credit_expiration_date" class="block text-sm font-medium text-gray-700">
                            Credit expiration date
                        </label>
                        <div class="relative mt-1">
                            <input type="date" id="credit_expiration_date" name="credit_expiration_date"
                                class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm rounded-md" />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H3a1 1 0 00-1 1v1h16V5a1 1 0 00-1-1h-2V3a1 1 0 00-1-1H6zm12 7H2v7a1 1 0 001 1h14a1 1 0 001-1V9zM5 11a1 1 0 100 2h10a1 1 0 100-2H5z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/6 p-1">
                        <x-label for="free_loading_unloading_hours" value="{{ __('Free loading and unloading') }}" />
                        <x-input id="free_loading_unloading_hours" placeholder="Free loading and unloading"
                            type="text" name="free_loading_unloading_hours" class="mt-1 block w-full" />
                        @error('free_loading_unloading_hours')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/6 p-1">
                        <x-label for="factory_company_id" value="{{ __('Factoring Company') }}" />
                        <select id="factory_company_id" name="factory_company_id"
                            class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs text-gray-800">
                            <option value="">Select a company</option>
                            @foreach ($factoryCompanies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                        @error('factory_company_id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!-- Right Column -->
                <div class="w-full lg:w-2/12 p-4">
                    <div x-data="{ photoName: null, photoPreview: null }">
                        <input type="file" id="picture" class="hidden" name="picture" x-ref="picture"
                            x-on:change="
                            photoName = $refs.picture.files[0].name;
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                photoPreview = e.target.result;
                            };
                            reader.readAsDataURL($refs.picture.files[0]);
                        " />
                        <x-label for="picture" value="{{ __('Picture') }}" />
                        <!-- Photo Preview -->
                        <div class="mt-2" x-show="!photoPreview">
                            <div class="w-56 h-56 bg-gray-300 flex items-center justify-center">
                                <span class="text-gray-500">N/A</span>
                            </div>
                        </div>
                        <div class="mt-2" x-show="photoPreview" style="display: none;">
                            <img :src="photoPreview" alt="Preview" class="w-56 h-56 object-cover rounded-md">
                        </div>
                        <x-button type="button" class="mt-2" x-on:click.prevent="$refs.picture.click()">
                            Select Picture
                        </x-button>
                    </div>
                </div>
            </div>
            <!-- Notes Section -->
            <div class="w-full">
                <div class="flex flex-wrap items-center gap-2">
                    <!-- Notes Input -->
                    <div class="w-full md:w-5/12">
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea id="notes" name="notes" rows="3"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                    </div>
                    <!-- Document Expiration Date Input -->
                    <div class="w-full md:w-4/12">
                        <label for="document_expiration_date" class="block text-sm font-medium text-gray-700">Select
                            the document's expiration date</label>
                        <div class="relative mt-1">
                            <input id="document_expiration_date" name="document_expiration_date" type="date"
                                class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 11h14a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2z" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <!-- Document Input -->
                    <div class="w-full md:w-2/12">
                        <label for="add_document" class="block text-sm font-medium text-gray-700">Document</label>
                        <input type="file" id="add_document" name="add_document"
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                    </div>
                </div>
            </div>

            <!-- Campo adicional solo para Station -->
            <div class="w-full">
                <div class="flex flex-wrap items-center gap-2">
                    @if ($type === 'station')
                        <div class="w-full lg:w-1/3 p-2">
                            <x-label for="tarifario" value="Tarifario" />
                            <input type="file" id="tarifario" name="tarifario"
                                class="block w-full border-gray-300 rounded-md">
                            @error('tarifario')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>
            </div>

            <!-- Campo adicional solo para Suppliers -->
            <div class="w-full">
                <div class="flex flex-wrap items-center gap-2">
                    @if ($type === 'supplier')
                        <div class="w-full lg:w-2/12 p-2">
                            <x-label for="tarifario" value="Tarifario" />
                            <input type="file" id="tarifario" name="tarifario"
                                class="block w-full border-gray-300 rounded-md">
                            @error('tarifario')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div x-show="type === 'supplier'" class="mt-6">
                            <h3 class="font-semibold text-lg">Supplier Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- MC Number -->
                                <div>
                                    <x-label for="mc_number" value="{{ __('MC Number') }}" />
                                    <x-input id="mc_number" type="text" name="mc_number" class="block mt-1 w-full" />
                                </div>
                                <!-- USDOT -->
                                <div>
                                    <x-label for="usdot" value="{{ __('USDOT') }}" />
                                    <x-input id="usdot" type="text" name="usdot" class="block mt-1 w-full" />
                                </div>
                                <!-- SCAC -->
                                <div>
                                    <x-label for="scac" value="{{ __('SCAC') }}" />
                                    <x-input id="scac" type="text" name="scac" class="block mt-1 w-full" />
                                </div>
                                <!-- CAAT -->
                                <div>
                                    <x-label for="caat" value="{{ __('CAAT') }}" />
                                    <x-input id="caat" type="text" name="caat" class="block mt-1 w-full" />
                                </div>
                            </div>
                        
                            <div class="mt-4">
                                <x-label for="services" value="{{ __('Select services') }}" />
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                    @foreach ($services as $service)
                                        <div>
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="services[]" value="{{ $service->id }}"
                                                    {{ isset($supplier) && $supplier->services->contains($service->id) ? 'checked' : '' }}
                                                    class="rounded border-gray-300 text-red-500 shadow-sm focus:ring focus:ring-offset-0 focus:ring-red-500 focus:ring-opacity-50">
                                                <span class="ml-2 text-gray-700">{{ $service->name }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                        </div>
                        
                    @endif
                </div>
            </div>


            <!-- Buttons -->
            <div class="mt-6 flex space-x-4">

                <a href="{{ route('business-directory.index') }}"
                    class="px-4 py-2 bg-zinc-950 text-white rounded-md shadow hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:ring-offset-2 flex items-center">
                    Cancel
                </a>
                <x-button>Save</x-button>
            </div>
            @error('type')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </form>
    </div>
</x-app-layout>
