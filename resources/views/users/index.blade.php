<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users admin secction') }}
        </h2>
    </x-slot>

    <div class="ms-12 me-12">
        <form method="POST" action="{{ route('users.store') }}" class="space-y-6" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-wrap">
                <div id="user-inputs-01" class="w-full sm:w-1/2 md:w-2/3 lg:w-3/4 xl:w-4/5 xl:pr-10">
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/3 p-1">
                            <x-label for="name" value="{{ __('Name') }}" />
                            <x-input id="name" placeholder="Name" type="text" class="mt-1 block w-full"
                                name="name" required />
                            @error('name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/3 p-1">
                            <x-label for="last_name" value="{{ __('Last Name') }}" />
                            <x-input id="last_name" placeholder="Last Name" type="text" class="mt-1 block w-full"
                                name="last_name" required />
                            @error('last_name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/3 p-1">
                            <x-label for="phone" value="{{ __('Phone') }}" />
                            <x-input id="phone" placeholder="phone" type="text" class="mt-1 block w-full"
                                name="phone" required />
                            @error('phone')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/3 p-1">
                            <x-label for="job_title" value="{{ __('Job Title') }}" />
                            <x-input id="job_title" placeholder="Job Title" type="text" class="mt-1 block w-full"
                                name="job_title" required />
                            @error('job_title')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/3 p-1">
                            <x-label for="office" value="{{ __('Office') }}" />
                            <x-input id="office" placeholder="Office" type="text" class="mt-1 block w-full"
                                name="office" required />
                            @error('office')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/3 p-1">
                            <x-label for="role" value="{{ __('Role') }}" />
                            <select id="role"
                                class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs text-gray-800 placeholder:text-gray-400"
                                name="role" required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/3 p-1">
                            <x-label for="email" value="{{ __('Email') }}" />
                            <x-input id="email" placeholder="Email" type="email" class="mt-1 block w-full"
                                name="email" required />
                            @error('email')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/3 p-1">
                            <x-label for="password" value="{{ __('Password') }}" />
                            <x-input id="password" placeholder="Password" type="password" class="mt-1 block w-full"
                                name="password" required />
                            @error('password')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <x-button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold mt-3 py-2 px-4 rounded">
                        {{ __('Create User') }}
                    </x-button>
                </div>
                <div id="user-inputs-02" class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/6">
                    <div class="flex flex-wrap">
                        <div x-data="{ photoName: null, photoPreview: null }">
                            <input type="file" id="photo" class="hidden" name="picture" x-ref="photo"
                                x-on:change="
                                        photoName = $refs.photo.files[0].name;
                                        const reader = new FileReader();
                                        reader.onload = (e) => {
                                            photoPreview = e.target.result;
                                        };
                                        reader.readAsDataURL($refs.photo.files[0]);
                                   " />
                            <x-label for="photo" value="{{ __('Add Picture') }}" />
                            <!-- Current Profile Photo -->
                            <div class="mt-2" x-show="! photoPreview">
                                {{-- <img src="" alt="Profile Photo" class=" bg-gray-600 h-56 w-56 object-cover"> --}}
                                <div
                                    class="w-56 h-56 bg-gray-600 flex items-center justify-center text-4xl text-white font-s">
                                    N/A
                                </div>
                            </div>
                            <!-- New Profile Photo Preview -->
                            <div class="mt-2" x-show="photoPreview" style="display: none;">
                                <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                                    x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                                </span>
                            </div>
                            <x-secondary-button class="mt-2" type="button"
                                x-on:click.prevent="$refs.photo.click()">
                                {{ __('Select A New Photo') }}
                            </x-secondary-button>
                        </div>

                    </div>
                </div>
                
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{-- @hasrole('coordinator')
                <p>Este texto solo lo puede ver el coordinador.</p>
            @endhasrole
            @hasanyrole('admin|coordinator')
                <p>Este texto lo pueden ver tanto los administradores como los coordinadores.</p>
            @endhasanyrole --}}
        </form>

        <div class="relative mt-12 overflow-x-auto">
            @livewire('users-list')
        </div>
    </div>
</x-app-layout>
