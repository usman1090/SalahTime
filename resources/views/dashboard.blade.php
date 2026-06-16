<x-app-layout>
    @php
        $completionPercent = round(($completedCount / 5) * 100);
        $remainingCount = max(0, 5 - $completedCount - $missedCount);
        $statusStyles = [
            'on_time' => 'border-emerald-200 bg-emerald-50 text-emerald-800',
            'late' => 'border-amber-200 bg-amber-50 text-amber-800',
            'qaza' => 'border-orange-200 bg-orange-50 text-orange-800',
            'missed' => 'border-rose-200 bg-rose-50 text-rose-800',
            'default' => 'border-slate-200 bg-slate-50 text-slate-600',
        ];
    @endphp

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <section class="mb-8 rounded-2xl bg-slate-950 px-6 py-7 text-white shadow-xl shadow-slate-200 sm:px-8">
                <div class="grid gap-8 lg:grid-cols-[1.4fr_0.8fr] lg:items-center">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-teal-200">{{ now()->format('l, d M Y') }}</p>
                        <h1 class="mt-3 text-3xl font-semibold tracking-tight sm:text-4xl">
                            Assalamu Alaikum, {{ auth()->user()->name }}
                        </h1>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300 sm:text-base">
                            Track today's Salah, review your monthly consistency, and keep your groups updated from one focused workspace.
                        </p>
                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('groups.index') }}" class="inline-flex items-center justify-center rounded-lg border border-white/15 bg-white/10 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/15">
                                View Groups
                            </a>
                            <a href="{{ route('groups.create') }}" class="inline-flex items-center justify-center rounded-lg bg-teal-400 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-teal-300">
                                Create Group
                            </a>
                        </div>
                    </div>

                    <div class="rounded-xl border border-white/10 bg-white/5 p-5">
                        <div class="flex items-end justify-between gap-4">
                            <div>
                                <p class="text-sm text-slate-300">Today completed</p>
                                <p class="mt-2 text-4xl font-semibold">{{ $completedCount }} / 5</p>
                            </div>
                            <p class="rounded-full bg-teal-400/15 px-3 py-1 text-sm font-semibold text-teal-200">{{ $completionPercent }}%</p>
                        </div>
                        <div class="mt-5 h-2 rounded-full bg-white/10">
                            <div class="h-2 rounded-full bg-teal-300" style="width: {{ $completionPercent }}%"></div>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                            <div class="rounded-lg bg-white/5 p-3">
                                <p class="text-slate-400">Remaining</p>
                                <p class="mt-1 font-semibold text-white">{{ $remainingCount }}</p>
                            </div>
                            <div class="rounded-lg bg-white/5 p-3">
                                <p class="text-slate-400">Missed</p>
                                <p class="mt-1 font-semibold text-white">{{ $missedCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            @if(session('success'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            <section class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-4">
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Completed Today</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-950">{{ $completedCount }} / 5</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Current Streak</p>
                    <p class="mt-2 text-3xl font-semibold text-teal-800">{{ $currentStreak }} days</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Best Streak</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-950">{{ $bestStreak }} days</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Groups</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-950">{{ $groups->count() }}</p>
                </div>
            </section>

            <section class="mb-8 rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-950">Today's Prayers</h2>
                        <p class="mt-1 text-sm text-slate-500">Upload proof and mark each prayer as completed for today.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5">
                    @foreach($prayers as $prayer)
                        @php
                            $record = $todayRecords[$prayer] ?? null;
                            $statusText = $record ? ucfirst(str_replace('_', ' ', $record->status)) : 'Not Marked';
                            $statusClass = $statusStyles[$record?->status] ?? $statusStyles['default'];
                        @endphp

                        <article class="flex min-h-full flex-col rounded-xl border border-slate-200 bg-slate-50/70 p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h3 class="text-lg font-semibold capitalize text-slate-950">{{ $prayer }}</h3>
                                    @if($record && $record->prayer_time)
                                        <p class="mt-1 text-sm text-slate-500">{{ $record->prayer_time->format('h:i A') }}</p>
                                    @else
                                        <p class="mt-1 text-sm text-slate-500">Awaiting update</p>
                                    @endif
                                </div>
                                <span class="rounded-full border px-2.5 py-1 text-xs font-semibold {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </div>

                            @if($record && $record->image_path)
                                <img
                                    src="{{ asset('storage/' . $record->image_path) }}"
                                    class="mt-4 h-28 w-full rounded-lg object-cover"
                                    alt="Prayer proof"
                                >
                            @else
                                <div class="mt-4 flex h-28 items-center justify-center rounded-lg border border-dashed border-slate-300 bg-white text-sm text-slate-400">
                                    No proof uploaded
                                </div>
                            @endif

                            <form method="POST" action="{{ route('prayers.store') }}" enctype="multipart/form-data" class="mt-4">
                                @csrf
                                <input type="hidden" name="prayer_name" value="{{ $prayer }}">
                                <input type="file" name="proof_image" accept="image/*" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-slate-100 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-200">
                                @error('proof_image')
                                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                                <button class="mt-3 w-full rounded-lg bg-teal-700 px-3 py-2 text-sm font-semibold text-white transition hover:bg-teal-800">
                                    Mark Prayer
                                </button>
                            </form>

                            @if($record)
                                <form method="POST" action="{{ route('prayers.destroy', $record) }}" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                                        Remove
                                    </button>
                                </form>
                            @endif
                        </article>
                    @endforeach
                </div>
            </section>

            <div class="grid gap-8 lg:grid-cols-[0.95fr_1.05fr]">
                <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                    <h2 class="text-xl font-semibold text-slate-950">Today's Prayer Times</h2>
                    <div class="mt-5 space-y-3">
                        @foreach($prayers as $prayer)
                            <div class="flex items-center justify-between rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                                <span class="font-semibold capitalize text-slate-800">{{ $prayer }}</span>
                                <span class="text-sm font-medium text-slate-600">{{ \Carbon\Carbon::parse($prayerTimes->$prayer)->format('h:i A') }}</span>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-950">My Groups</h2>
                            <p class="mt-1 text-sm text-slate-500">Invite codes and shared accountability spaces.</p>
                        </div>
                        <a href="{{ route('groups.join.form') }}" class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Join
                        </a>
                    </div>

                    <div class="mt-5 divide-y divide-slate-200">
                        @forelse($groups as $group)
                            <div class="py-4 first:pt-0 last:pb-0">
                                <h3 class="font-semibold text-slate-950">{{ $group->name }}</h3>
                                <p class="mt-1 text-sm text-slate-500">Invite Code: <span class="font-mono font-semibold text-slate-700">{{ $group->invite_code }}</span></p>
                            </div>
                        @empty
                            <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 p-5 text-sm text-slate-500">
                                You have not joined any groups yet.
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>

            <section class="mt-8 rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <div class="mb-5">
                    <h2 class="text-xl font-semibold text-slate-950">This Month's Stats</h2>
                    <p class="mt-1 text-sm text-slate-500">A quick view of your prayer record for {{ now()->format('F') }}.</p>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
                    <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                        <p class="text-sm font-medium text-slate-500">Total</p>
                        <p class="mt-2 text-2xl font-semibold text-slate-950">{{ $monthlyStats['total'] }}</p>
                    </div>
                    <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-4">
                        <p class="text-sm font-medium text-emerald-700">On Time</p>
                        <p class="mt-2 text-2xl font-semibold text-emerald-900">{{ $monthlyStats['on_time'] }}</p>
                    </div>
                    <div class="rounded-lg border border-amber-200 bg-amber-50 p-4">
                        <p class="text-sm font-medium text-amber-700">Late</p>
                        <p class="mt-2 text-2xl font-semibold text-amber-900">{{ $monthlyStats['late'] }}</p>
                    </div>
                    <div class="rounded-lg border border-orange-200 bg-orange-50 p-4">
                        <p class="text-sm font-medium text-orange-700">Qaza</p>
                        <p class="mt-2 text-2xl font-semibold text-orange-900">{{ $monthlyStats['qaza'] }}</p>
                    </div>
                    <div class="rounded-lg border border-rose-200 bg-rose-50 p-4">
                        <p class="text-sm font-medium text-rose-700">Missed</p>
                        <p class="mt-2 text-2xl font-semibold text-rose-900">{{ $monthlyStats['missed'] }}</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
