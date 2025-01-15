<div class="mb-10">
    <div class="table-header ">
        <x-input placeholder="Search User" wire:model="search" wire:keydown="refreshComponent"></x-input>
    </div>
    @if($users->count())
    {{-- Table for displaying user data --}}
    <table class="min-w-full mt-4">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-4 py-2 text-left">ID</th>
                <th scope="col" class="px-4 py-2 text-left">Name</th>
                <th scope="col" class="px-4 py-2 text-left">Phone</th>
                <th scope="col" class="px-4 py-2 text-left">Email</th>
                <th scope="col" class="px-4 py-2 text-left">Job Title</th>
                <th scope="col" class="px-4 py-2 text-left">Role</th>
                <th scope="col" class="px-4 py-2 text-left">Pic</th>
                <th scope="col" class="px-4 py-2 text-left">Watch</th>
            </tr>
        </thead>
        <tbody>
            {{-- Loop through each user and display their data --}}
            @foreach ($users as $user)
                <tr
                    class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                    <td class="px-4 py-2">{{ $user->id }}</td>
                    <td class="px-4 py-2">{{ $user->name }}</td>
                    <td class="px-4 py-2">{{ $user->phone }}</td>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                    <td class="px-4 py-2">{{ $user->job_title }}</td>
                    <td class="px-4 py-2">
                        @if($user->roles->isNotEmpty())
                            {{ $user->getRoleNames()->implode(', ') }} {{-- Display multiple roles if the user has more than one --}}
                        @else
                            <span>No Role Assigned</span>
                        @endif
                    </td>
                    
                    <td class="px-4 py-2">
                        @if($user->profile_photo_path)
                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Pic" class="h-10 w-10 rounded-full">
                        @else
                            <span>N/A</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        <form action="{{ route('users.edit', $user) }}" method="GET" style="display:inline;">
                            <x-button type="submit">
                                Edit
                            </x-button>
                        </form>                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination Links --}}
    <div class="list-footer mt-4">
        {{ $users->links() }}
    </div>
    @else
        <div class="card-body">
            No Users
        </div>
    @endif
</div>
