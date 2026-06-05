<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4">

            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h1 class="text-2xl font-bold">{{ $group->name }}</h1>

                <p class="text-gray-500 mt-2">
                    {{ $group->description ?? 'No description added.' }}
                </p>

                <div class="flex gap-4 mt-4 text-sm">
                    <span>
                        <strong>Invite Code:</strong>
                        {{ $group->invite_code }}
                    </span>

                    <span>
                        <strong>Members:</strong>
                        {{ $members->count() }}
                    </span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">

                <h2 class="text-xl font-bold mb-4">
                    Today's Group Prayer Status
                </h2>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">

                        <thead>
                            <tr class="bg-gray-100">
                                <th class="text-left p-3 border">Member</th>

                                @foreach($prayers as $prayer)
                                    <th class="text-center p-3 border capitalize">
                                        {{ $prayer }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($members as $member)

                                @php
                                    $memberRecords = $records[$member->id] ?? collect();
                                @endphp

                                <tr>
                                    <td class="p-3 border">
                                        <div class="font-semibold">
                                            {{ $member->name }}
                                        </div>

                                        @if($member->id === $group->owner_id)
                                            <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">
                                                Owner
                                            </span>
                                        @endif
                                    </td>

                                    @foreach($prayers as $prayer)

                                        @php
                                            $record = $memberRecords
                                                ->where('prayer_name', $prayer)
                                                ->first();

                                            $status = $record?->status;

                                            $badgeClass = match($status) {
                                                'on_time' => 'bg-green-100 text-green-700',
                                                'late' => 'bg-yellow-100 text-yellow-700',
                                                'qaza' => 'bg-orange-100 text-orange-700',
                                                'missed' => 'bg-red-100 text-red-700',
                                                default => 'bg-gray-100 text-gray-500',
                                            };

                                            $statusText = $status
                                                ? ucfirst(str_replace('_', ' ', $status))
                                                : 'Not Marked';
                                        @endphp

                                        <td class="p-3 border text-center">
                                            <span class="inline-block px-3 py-1 rounded text-sm font-semibold {{ $badgeClass }}">
                                                {{ $statusText }}
                                            </span>
                                        </td>

                                    @endforeach
                                </tr>

                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>