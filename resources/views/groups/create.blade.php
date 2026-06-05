<x-app-layout>
    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4">

            <div class="bg-white p-6 rounded-lg shadow">
                <h1 class="text-2xl font-bold mb-6">Create Group</h1>

                <form method="POST" action="{{ route('groups.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Group Name</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="w-full border-gray-300 rounded">
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Description</label>
                        <textarea name="description" rows="4"
                                  class="w-full border-gray-300 rounded">{{ old('description') }}</textarea>
                    </div>

                    <button class="bg-blue-600 text-white px-5 py-2 rounded">
                        Create Group
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>