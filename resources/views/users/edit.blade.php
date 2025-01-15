<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if(session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-4 p-4">
                    @csrf
                    @method('PUT')
    
                    <div class="mt-4 md:col-span-6">
                        <x-label for="name" :value="__('Name')" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $user->name }}" required autofocus />
                    </div>
    
                    <div class="mt-4 md:col-span-6">
                        <x-label for="last_name" :value="__('Last Name')" />
                        <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" value="{{ $user->last_name }}" required />
                    </div>
    
                    <div class="mt-4 md:col-span-4">
                        <x-label for="email" :value="__('Email')" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ $user->email }}" required />
                    </div>
    
                    <div class="mt-4 md:col-span-4">
                        <x-label for="phone" :value="__('Phone')" />
                        <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" value="{{ $user->phone }}" required />
                    </div>
    
                    <div class="mt-4 md:col-span-4">
                        <x-label for="job_title" :value="__('Job Title')" />
                        <x-input id="job_title" class="block mt-1 w-full" type="text" name="job_title" value="{{ $user->job_title }}" required />
                    </div>
    
                    <div class="mt-4 md:col-span-3">
                        <x-label for="office" :value="__('Office')" />
                        <x-input id="office" class="block mt-1 w-full" type="text" name="office" value="{{ $user->office }}" required />
                    </div>
                    
                    <div class="mt-4 md:col-span-3">
                        <x-label for="role" :value="__('Role')" />
                        <select id="role" name="role" class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md text-xs text-gray-800 placeholder:text-gray-400" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->roles->contains($role) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Campo para la contraseña -->
                    <div class="mt-4 md:col-span-6">
                        <x-label for="password" :value="__('New Password')" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" />
                        <small class="text-gray-500">{{ __('Leave empty if you don\'t want to change the password.') }}</small>
                    </div>

                    <div class="mt-4 md:col-span-6">
                        <x-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
                    </div>

                    <!-- Campo para la foto de perfil -->
                    <div id="user-inputs-02" class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/6">
                        <div class="flex flex-wrap">
                            <div x-data="{ photoName: null, photoPreview: '{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : '' }}' }">
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
                                <div class="mt-2" x-show="!photoPreview">
                                    @if($user->profile_photo_path)
                                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Photo" class="bg-gray-600 h-56 w-56 object-cover rounded-full">
                                    @else
                                        <div class="w-56 h-56 bg-gray-600 flex items-center justify-center text-4xl text-white font-s">
                                            N/A
                                        </div>
                                    @endif
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
                    
    
                    <div class="md:col-span-12 mt-2 ml-auto">
                        <x-button class="w-full flex items-center justify-center">
                            {{ __('Update') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>