<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4">

            <div class="flex justify-between items-center mb-6">

    <div>
        <h1 class="text-2xl font-bold">
            Assalamu Alaikum, {{ auth()->user()->name }}
        </h1>

        <p class="text-gray-500">
            Track your Salah for today.
        </p>
    </div>

    <div class="flex gap-3">

        <a href="{{ route('groups.index') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg">
            Groups
        </a>

        <a href="{{ route('groups.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded-lg">
            Create Group
        </a>

    </div>

</div>
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">

                <div class="bg-white rounded-lg shadow p-5">
                    <p class="text-gray-500">Completed Today</p>
                    <h2 class="text-3xl font-bold">
                        {{ $completedCount }} / 5
                    </h2>
                </div>

                <div class="bg-white rounded-lg shadow p-5">
                    <p class="text-gray-500">Missed</p>
                    <h2 class="text-3xl font-bold">
                        {{ $missedCount }}
                    </h2>
                </div>

                <div class="bg-white rounded-lg shadow p-5">
                    <p class="text-gray-500">Date</p>
                    <h2 class="text-3xl font-bold">
                        {{ now()->format('d M') }}
                    </h2>
                </div>

            </div>

            <div class="bg-white rounded-lg shadow p-6 mb-8">

                <h2 class="text-xl font-bold mb-4">
                    Today's Prayers
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

                    @foreach($prayers as $prayer)

                        @php
                            $record = $todayRecords[$prayer] ?? null;

                            $statusClass = match($record?->status) {
                                'on_time' => 'bg-green-100 text-green-700',
                                'late' => 'bg-yellow-100 text-yellow-700',
                                'qaza' => 'bg-orange-100 text-orange-700',
                                'missed' => 'bg-red-100 text-red-700',
                                default => 'bg-gray-100 text-gray-600',
                            };

                            $statusText = $record
                                ? ucfirst(str_replace('_', ' ', $record->status))
                                : 'Not Marked';
                        @endphp

                        <div class="border rounded-lg p-4">

                            <h3 class="text-lg font-bold capitalize mb-2">
                                {{ $prayer }}
                            </h3>

                            <span class="inline-block px-3 py-1 rounded text-sm font-semibold {{ $statusClass }}">
                                {{ $statusText }}
                            </span>

                            @if($record && $record->prayer_time)
                                <p class="text-sm text-gray-500 mt-2">
                                    {{ $record->prayer_time->format('h:i A') }}
                                </p>
                            @endif

                            <form method="POST" action="{{ route('prayers.store') }}" class="mt-4">
                                @csrf

                                <input type="hidden" name="prayer_name" value="{{ $prayer }}">

                                <button class="w-full bg-blue-600 text-white px-3 py-2 rounded text-sm">
                                Mark Prayer
                            </button>
                            </form>

                            @if($record)
                                <form method="POST" action="{{ route('prayers.destroy', $record) }}" class="mt-2">
                                    @csrf
                                    @method('DELETE')

                                    <button class="w-full bg-gray-200 text-gray-700 px-3 py-2 rounded text-sm">
                                        Remove
                                    </button>
                                </form>
                            @endif

                        </div>

                    @endforeach

                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 mb-8">

            <h2 class="text-xl font-bold mb-4">
                Today's Prayer Times
            </h2>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

            @foreach($prayers as $prayer)

                <div class="border rounded-lg p-4 text-center">
                    <h3 class="font-bold capitalize">
                        {{ $prayer }}
                    </h3>

                    <p class="text-gray-600 mt-2">
                        {{ \Carbon\Carbon::parse($prayerTimes->$prayer)->format('h:i A') }}
                    </p>
                </div>

            @endforeach

                </div>

        </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">
                    My Groups
                </h2>

                @forelse($groups as $group)
                    <div class="border-b py-3">
                        <h3 class="font-semibold">{{ $group->name }}</h3>
                        <p class="text-sm text-gray-500">
                            Invite Code: {{ $group->invite_code }}
                        </p>
                    </div>
                @empty
                    <p class="text-gray-500">
                        You have not joined any groups yet.
                    </p>
                @endforelse
            </div>


            <div class="bg-white rounded-lg shadow p-6 mt-8">

    <h2 class="text-xl font-bold mb-4">
        This Month's Stats
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

        <div class="border rounded-lg p-4 text-center">
            <p class="text-gray-500">Total</p>
            <h3 class="text-2xl font-bold">{{ $monthlyStats['total'] }}</h3>
        </div>

        <div class="border rounded-lg p-4 text-center">
            <p class="text-gray-500">On Time</p>
            <h3 class="text-2xl font-bold text-green-600">{{ $monthlyStats['on_time'] }}</h3>
        </div>

        <div class="border rounded-lg p-4 text-center">
            <p class="text-gray-500">Late</p>
            <h3 class="text-2xl font-bold text-yellow-600">{{ $monthlyStats['late'] }}</h3>
        </div>

        <div class="border rounded-lg p-4 text-center">
            <p class="text-gray-500">Qaza</p>
            <h3 class="text-2xl font-bold text-orange-600">{{ $monthlyStats['qaza'] }}</h3>
        </div>

        <div class="border rounded-lg p-4 text-center">
            <p class="text-gray-500">Missed</p>
            <h3 class="text-2xl font-bold text-red-600">{{ $monthlyStats['missed'] }}</h3>
        </div>

    </div>
</div>

        </div>

    </div>
</x-app-layout>