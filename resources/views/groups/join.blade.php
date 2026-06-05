<x-app-layout>
    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4">

            <div class="bg-white p-6 rounded-lg shadow">
                <h1 class="text-2xl font-bold mb-2">Join Group</h1>
                <p class="text-gray-500 mb-6">Enter the invite code your friend shared with you.</p>

                <form method="POST" action="{{ route('groups.join') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Invite Code</label>
                        <input type="text" name="invite_code" value="{{ old('invite_code') }}"
                               class="w-full border-gray-300 rounded uppercase"
                               placeholder="Example: A7B9KQ2P">

                        @error('invite_code')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button class="bg-blue-600 text-white px-5 py-2 rounded">
                        Join Group
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>