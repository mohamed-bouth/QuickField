<form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-8">
    @csrf
    @method('PUT')

    <!-- General Information -->
    <div class="space-y-6">
        <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-100 pb-2">
            Edit User Information
        </h3>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <h1>Validation Error</h1>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Name -->
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700">Full Name *</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    class="w-full rounded-xl border border-gray-300 focus:border-green-600 focus:ring-green-600 h-12 px-4 text-sm outline-none"
                >
            </div>

            <!-- Email -->
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700">Email *</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    class="w-full rounded-xl border border-gray-300 focus:border-green-600 focus:ring-green-600 h-12 px-4 text-sm outline-none"
                >
            </div>

            <!-- Phone -->
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700">Phone *</label>
                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone', $user->phone) }}"
                    class="w-full rounded-xl border border-gray-300 focus:border-green-600 focus:ring-green-600 h-12 px-4 text-sm outline-none"
                >
            </div>

            <!-- Status -->
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700">Status</label>
                <select
                    name="status"
                    class="w-full rounded-xl border border-gray-300 focus:border-green-600 focus:ring-green-600 h-12 px-3 text-sm bg-white outline-none"
                >
                    <option value="active" @selected($user->status === 'active')>Active</option>
                    <option value="inactive" @selected($user->status === 'inactive')>Inactive</option>
                </select>
            </div>

            <!-- Password -->
            <div class="space-y-2 md:col-span-2">
                <label class="text-sm font-medium text-gray-700">
                    Password (leave empty if not changing)
                </label>
                <input
                    type="password"
                    name="password"
                    placeholder="********"
                    class="w-full rounded-xl border border-gray-300 focus:border-green-600 focus:ring-green-600 h-12 px-4 text-sm outline-none"
                >
            </div>

        </div>
    </div>

    <!-- Actions -->
    <div class="border-t border-gray-100 pt-6 flex items-center justify-end gap-3">
        <a href="{{ route('admin.users.index') }}"
           class="rounded-xl px-6 h-12 border border-gray-200 inline-flex items-center justify-center text-sm text-gray-700 bg-white">
            Cancel
        </a>

        <button
            type="submit"
            class="bg-green-600 hover:bg-green-700 text-white rounded-xl px-8 h-12 inline-flex items-center justify-center text-sm font-medium"
        >
            Update User
        </button>
    </div>
</form>