<div x-data="{ open: @entangle('closed') }" class="relative md:flex">
    <!-- Sidebar -->
    <aside :class="{ '-translate-x-full': !open }" class="fixed top-0 left-0 z-20 w-9/12 h-screen overflow-y-auto transition-transform duration-300 ease-in-out transform -translate-x-full bg-white shadow-2xl sm:w-64">
        <!-- Logo -->
        <div class="flex items-center justify-between px-2">
            <div class="flex items-center pt-2 text-gray-600">
                <a href="#">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 18.364A8.966 8.966 0 0112 15.5a8.966 8.966 0 016.879 2.864M15 11a4 4 0 10-8 0 4 4 0 008 0z"></path>
                    </svg>
                </a>
                <span class="pl-2 pt-1 space-x-2">
                    {{ ucfirst(auth()->user()->getRoleNames()->first()) }} User
                </span>
            </div>
            
            
            <button @click="open = !open" class="inline-flex items-center justify-center mt-2 p-2 rounded-md text-red-500 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
        </div>
        <!-- Navigation Links -->
        <nav>
            @foreach ($navLinks as $link)
                @if ((isset($link['permission']) && auth()->user()->can($link['permission'])) || (isset($link['role']) && auth()->user()->hasRole($link['role'])))
                    <x-side-nav-link href="{{ route($link['route']) }}" :active="request()->routeIs($link['route'])">
                        {!! $link['icon'] !!} <!-- Renderiza el icono de FontAwesome -->
                        {{ $link['label'] }}
                    </x-side-nav-link>
                @endif
            @endforeach
        </nav>
        
        
        
    </aside>
    <!-- Toggle button -->
    <div class="fixed top-3 left-0 z-10 flex items-center">
        <button @click="open = !open" @click.away="open = false" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
    </div>
</div>
