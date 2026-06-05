<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold">My Groups</h1>
                    <p class="text-gray-500">
                        Track Salah together with your friends.
                    </p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('groups.join.form') }}"
                       class="bg-gray-800 text-white px-4 py-2 rounded">
                        Join Group
                    </a>

                    <a href="{{ route('groups.create') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded">
                        Create Group
                    </a>
                </div>
            </div>

            @forelse($groups as $group)

                <div class="bg-white rounded-lg shadow p-5 mb-4">

                    <h2 class="text-xl font-bold">
                        {{ $group->name }}
                    </h2>

                    <p class="text-gray-500 mt-2">
                        {{ $group->description }}
                    </p>

                    <div class="mt-3">
                        Invite Code:
                        <strong>{{ $group->invite_code }}</strong>
                    </div>

                    <a href="{{ route('groups.show', $group) }}"
                       class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded">
                        View Group
                    </a>

                </div>

            @empty

                <div class="bg-white rounded-lg shadow p-5">
                    No groups found.
                </div>

            @endforelse

        </div>
    </div>
</x-app-layout>