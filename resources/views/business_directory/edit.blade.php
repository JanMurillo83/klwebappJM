<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit') }} {{ $directory->type }} - {{ $directory->company }}
        </h2>
    </x-slot>

    <div class="ms-12 me-12">
        <form action="{{ route('business-directory.update', $directory->id) }}" method="POST"
            enctype="multipart/form-data" class="mt-4 mb-12">
            @csrf
            @method('PUT') <!-- Método PUT para la actualización -->

            <div class="flex flex-wrap">
                <!-- Left Column -->
                <div class="w-full lg:w-10/12 flex flex-wrap">
                    <!-- Row 1 -->
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-3/12 p-1">
                        <input type="hidden" name="type" value="{{ old('nickname', $directory->type) }}">
                        <x-label for="company" value="{{ __('Company') }}" />
                        <x-input id="company" placeholder="Customer Company" type="text" name="company"
                            class="mt-1 block w-full" required value="{{ old('company', $directory->company) }}" />
                        @error('company')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-2/12 p-1">
                        <x-label for="nickname" value="{{ __('Nickname') }}" />
                        <x-input id="nickname" placeholder="Placeholder" type="text" name="nickname"
                            class="mt-1 block w-full" value="{{ old('nickname', $directory->nickname) }}" />
                        @error('nickname')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/12 p-1">
                        <x-label for="billing_currency" value="{{ __('B. Currency') }}" />
                        <select id="billing_currency" name="billing_currency"
                            class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs text-gray-800 placeholder:text-gray-400">
                            <option value="MXN"
                                {{ old('billing_currency', $directory->billing_currency) == 'MXN' ? 'selected' : '' }}>
                                MXN</option>
                            <option value="USD"
                                {{ old('billing_currency', $directory->billing_currency) == 'USD' ? 'selected' : '' }}>
                                USD</option>
                        </select>
                    </div>
                    <!-- Row 2 -->
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-2/12 p-1">
                        <x-label for="rfc_tax_id" value="{{ __('RFC') }}" />
                        <x-input id="rfc_tax_id" placeholder="Tax ID" type="text" name="rfc_tax_id"
                            class="mt-1 block w-full" value="{{ old('rfc_tax_id', $directory->rfc_tax_id) }}" />
                        @error('rfc_tax_id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-3/12 p-1">
                        <x-label for="street_address" value="{{ __('Street Address') }}" />
                        <x-input id="street_address" placeholder="Placeholder" type="text" name="street_address"
                            class="mt-1 block w-full"
                            value="{{ old('street_address', $directory->street_address) }}" />
                        @error('street_address')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/12 p-1">
                        <x-label for="building_number" value="{{ __('Building #') }}" />
                        <x-input id="building_number" placeholder="Placeholder" type="text" name="building_number"
                            class="mt-1 block w-full"
                            value="{{ old('building_number', $directory->building_number) }}" />
                        @error('building_number')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Row 3 -->
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-4/12 p-1">
                        <x-label for="neighborhood" value="{{ __('Neighborhood') }}" />
                        <x-input id="neighborhood" placeholder="Placeholder" type="text" name="neighborhood"
                            class="mt-1 block w-full" value="{{ old('neighborhood', $directory->neighborhood) }}" />
                        @error('neighborhood')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-3/12 p-1">
                        <x-label for="city" value="{{ __('City') }}" />
                        <x-input id="city" placeholder="Placeholder" type="text" name="city"
                            class="mt-1 block w-full" value="{{ old('city', $directory->city) }}" />
                        @error('city')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-2/12 p-1">
                        <x-label for="state" value="{{ __('State') }}" />
                        <x-input id="state" placeholder="Placeholder" type="text" name="state"
                            class="mt-1 block w-full" value="{{ old('state', $directory->state) }}" />
                        @error('state')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/12 p-1">
                        <x-label for="postal_code" value="{{ __('Postal Code') }}" />
                        <x-input id="postal_code" placeholder="Placeholder" type="text" name="postal_code"
                            class="mt-1 block w-full" value="{{ old('postal_code', $directory->postal_code) }}" />
                        @error('postal_code')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/6 p-1">
                        <x-label for="phone" value="{{ __('Phone') }}" />
                        <x-input id="phone" placeholder="Placeholder" type="text" name="phone"
                            class="mt-1 block w-full" value="{{ old('phone', $directory->phone) }}" />
                        @error('phone')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/3 p-1">
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" placeholder="Placeholder" type="email" name="email"
                            class="mt-1 block w-full" value="{{ old('email', $directory->email) }}" />
                        @error('email')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/3 p-1">
                        <x-label for="website" value="{{ __('Website') }}" />
                        <x-input id="website" placeholder="Placeholder" type="url" name="website"
                            class="mt-1 block w-full" value="{{ old('website', $directory->website) }}" />
                        @error('website')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/3 p-1">
                        <x-label for="credit_days" value="{{ __('Credit Days') }}" />
                        <x-input id="credit_days" placeholder="Credit Days" type="number" name="credit_days"
                            class="mt-1 block w-full" value="{{ old('credit_days', $directory->credit_days) }}" />
                        @error('credit_days')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/3 p-1">
                        <x-label for="credit_expiration_date" value="{{ __('Credit Expiration Date') }}" />
                        <x-input id="credit_expiration_date" type="date" name="credit_expiration_date"
                            class="mt-1 block w-full"
                            value="{{ old('credit_expiration_date', $directory->credit_expiration_date) }}" />
                        @error('credit_expiration_date')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/3 p-1">
                        <x-label for="free_loading_unloading_hours" value="{{ __('Free Loading and Unloading') }}" />
                        <x-input id="free_loading_unloading_hours" placeholder="Hours" type="text"
                            name="free_loading_unloading_hours" class="mt-1 block w-full"
                            value="{{ old('free_loading_unloading_hours', $directory->free_loading_unloading_hours) }}" />
                        @error('free_loading_unloading_hours')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/3 p-1">
                        <x-label for="factory_company_id" value="{{ __('Factoring Company') }}" />
                        <select id="factory_company_id" name="factory_company_id"
                            class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs text-gray-800">
                            <option value="">Select a company</option>
                            @foreach ($factoryCompanies as $company)
                                <option value="{{ $company->id }}"
                                    {{ old('factory_company_id', $directory->factory_company_id) == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('factory_company_id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!-- Right Column -->
                <div class="w-full lg:w-2/12 pl-2" x-data="{ photoName: null, photoPreview: null }">
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
                    <!-- Existing Photo Preview -->
                    <div class="mt-2" x-show="!photoPreview && '{{ $directory->picture }}'">
                        <img src="{{ asset('storage/' . $directory->picture) }}" alt="Picture Preview"
                            class="w-56 h-56 object-cover rounded-md">
                    </div>
                    <!-- Placeholder for No Photo -->
                    <div class="mt-2" x-show="!photoPreview && !'{{ $directory->picture }}'">
                        <div class="w-56 h-56 bg-gray-300 flex items-center justify-center">
                            <span class="text-gray-500">N/A</span>
                        </div>
                    </div>
                    <!-- New Photo Preview -->
                    <div class="mt-2" x-show="photoPreview" style="display: none;">
                        <img :src="photoPreview" alt="Preview" class="w-56 h-56 object-cover rounded-md">
                    </div>
                    <!-- Button to Upload -->
                    <x-button type="button" class="mt-1" x-on:click.prevent="$refs.picture.click()">
                        Select Picture
                    </x-button>
                    @error('picture')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <!-- Notes Section -->
            <div class="w-full">
                <x-label for="notes" value="{{ __('Notes') }}" />
                <textarea id="notes" name="notes" rows="3"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('notes', $directory->notes) }}</textarea>
                @error('notes')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Document Upload Section -->
            <div class="w-full mt-1 flex flex-wrap items-center gap-4">
                <div x-data="{ showModal: false }">
                    <x-label for="add_document" value="{{ __('Document') }}" />
                    <div class="mt-1 block">
                        <div class="flex items-center gap-2">
                            @if ($directory->add_document)
                                <!-- Botón para abrir el modal -->
                                <button type="button" class="text-blue-600 hover:underline"
                                    x-on:click="showModal = true">
                                    <i class="fas fa-eye"></i> View Document
                                </button>
                            @else
                                <p class="text-gray-500">No document uploaded</p>
                            @endif

                            <!-- Botón para subir un documento -->
                            <x-button type="button" class="bg-red-500 text-white px-4"
                                x-on:click.prevent="$refs.documentInput.click()">
                                Upload a Document
                            </x-button>
                        </div>

                        <!-- Input de archivo escondido -->
                        <input type="file" id="add_document" name="add_document" x-ref="documentInput"
                            class="hidden" />
                    </div>
                    @error('add_document')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror

                    <!-- Modal -->
                    <div x-show="showModal" x-cloak
                        class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden w-3/4 h-3/4">
                            <div class="flex justify-between items-center p-4 border-b">
                                <h3 class="text-lg font-semibold">Document Preview</h3>
                                <!-- Botón para cerrar el modal -->
                                <button type="button" x-on:click.prevent="showModal = false"
                                    class="text-gray-600 hover:text-gray-900">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="p-4 h-full">
                                @if ($directory->add_document)
                                    <!-- Mostrar documento en iframe -->
                                    <iframe src="{{ asset('storage/' . $directory->add_document) }}"
                                        class="w-full h-full border rounded-md"></iframe>
                                @else
                                    <p class="text-sm text-gray-500">No document available to preview.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full pt-1">
                @if ($directory->type === 'station' || $directory->type === 'supplier')
                    <x-label for="tarifario" value="{{ __('Tarifario') }}" />
                    <div x-data="{ showTarifarioModal: false, tarifarioName: null }" class="mt-2">
                        <!-- Mostrar documento actual si existe -->
                        @if ($directory->tarifario)
                            <div class="flex items-center gap-2">
                                <button type="button" class="text-blue-600 hover:underline"
                                    x-on:click="showTarifarioModal = true">
                                    <i class="fas fa-eye"></i> View Tarifario
                                </button>
                                <a href="{{ asset('storage/' . $directory->tarifario) }}" target="_blank"
                                    class="text-gray-600 hover:underline">
                                    <i class="fas fa-download"></i> Download Tarifario
                                </a>
                            </div>
                        @else
                            <p class="text-gray-500">No tarifario uploaded</p>
                        @endif

                        <!-- Input para cargar nuevo tarifario -->
                        <input type="file" id="tarifario" name="tarifario" class="hidden" x-ref="tarifarioInput"
                            x-on:change="tarifarioName = $refs.tarifarioInput.files[0].name">
                        <x-button type="button" class="mt-2 bg-red-500 text-white"
                            x-on:click.prevent="$refs.tarifarioInput.click()">
                            Upload Tarifario
                        </x-button>
                        <p class="mt-2 text-sm text-gray-500" x-show="tarifarioName">Selected file: <span
                                x-text="tarifarioName"></span></p>

                        @error('tarifario')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror

                        <!-- Modal para previsualizar el tarifario -->
                        <div x-show="showTarifarioModal" x-cloak
                            class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
                            <div class="bg-white rounded-lg shadow-lg overflow-hidden w-3/4 h-3/4">
                                <div class="flex justify-between items-center p-4 border-b">
                                    <h3 class="text-lg font-semibold">Tarifario Preview</h3>
                                    <button type="button" x-on:click="showTarifarioModal = false"
                                        class="text-gray-600 hover:text-gray-900">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="p-4 h-full">
                                    @if ($directory->tarifario)
                                        <!-- Mostrar documento en iframe -->
                                        <iframe src="{{ asset('storage/' . $directory->tarifario) }}"
                                            class="w-full h-full border rounded-md"></iframe>
                                    @else
                                        <p class="text-sm text-gray-500">No tarifario available to preview.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @if ($directory->type === 'supplier')
                <div class="mt-4">
                    <h3 class="font-semibold text-lg">Supplier Details</h3>

                    <!-- Supplier-specific fields -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-label for="mc_number" value="{{ __('MC Number') }}" />
                            <x-input id="mc_number" type="text" name="mc_number" class="mt-1 block w-full"
                                value="{{ old('mc_number', $directory->supplier->mc_number ?? '') }}" />
                            @error('mc_number')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="usdot" value="{{ __('USDOT') }}" />
                            <x-input id="usdot" type="text" name="usdot" class="mt-1 block w-full"
                                value="{{ old('usdot', $directory->supplier->usdot ?? '') }}" />
                            @error('usdot')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="scac" value="{{ __('SCAC') }}" />
                            <x-input id="scac" type="text" name="scac" class="mt-1 block w-full"
                                value="{{ old('scac', $directory->supplier->scac ?? '') }}" />
                            @error('scac')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="caat" value="{{ __('CAAT') }}" />
                            <x-input id="caat" type="text" name="caat" class="mt-1 block w-full"
                                value="{{ old('caat', $directory->supplier->caat ?? '') }}" />
                            @error('caat')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Services -->
                    <div class="mt-4">
                        <x-label for="services" value="{{ __('Services Offered') }}" />
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                            @foreach ($services as $service)
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="services[]" value="{{ $service->id }}"
                                            {{ isset($directory->supplier) && $directory->supplier->services->pluck('id')->contains($service->id) ? 'checked' : '' }}
                                            class="rounded border-gray-300">
                                        <span class="ml-2 text-gray-700">{{ $service->name }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('services')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endif



            <!-- Buttons -->
            <div class="mt-6 flex space-x-4">
                <a href="{{ route('business-directory.index') }}"
                    class="px-4 py-2 bg-black text-white rounded-md shadow hover:bg-gray-700">
                    Cancel
                </a>
                <x-button class="bg-red-500">Save</x-button>
            </div>
        </form>



    </div>
</x-app-layout>
