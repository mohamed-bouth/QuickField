<form action="{{ route('admin.fields.update', $field->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')
    <div class="space-y-6">
        <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-100 pb-2">
            General Information
        </h3>
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <h1>Validation Error</h1>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700">Field Name *</label>
                <input
                    type="text"
                    name="name"
                    placeholder="e.g. Main Stadium 5v5"
                    class="w-full rounded-xl border border-gray-300 focus:border-green-600 focus:ring-green-600 h-12 px-4 text-sm text-gray-700 outline-none"
                    value="{{ old('name', $field->name) }}"
                >
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700">Localisation *</label>
                <input
                    type="text"
                    name="localisation"
                    placeholder="e.g. North Complex, Paris"
                    class="w-full rounded-xl border border-gray-300 focus:border-green-600 focus:ring-green-600 h-12 px-4 text-sm text-gray-700 outline-none"
                    value="{{ old('localisation', $field->localisation) }}"
                >
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Description</label>
            <textarea
                name="description"
                rows="4"
                placeholder="Provide details about the field surface, amenities, etc."
                class="w-full rounded-xl border border-gray-300 focus:border-green-600 focus:ring-green-600 p-3 text-sm text-gray-700 outline-none"
                
            >{{ old('description', $field->description) }}</textarea>
        </div>
    </div>

    <div class="space-y-6">
        <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-100 pb-2">
            Configuration
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700">Field Type</label>
                <select
                    name="type"
                    class="w-full rounded-xl border border-gray-300 focus:border-green-600 focus:ring-green-600 h-12 px-3 text-sm text-gray-700 bg-white outline-none"
                >
                    <option value="5v5" {{ old('type', $field->type) === '5v5' ? 'selected' : '' }}>5v5</option>
                    <option value="7v7" {{ old('type', $field->type) === '7v7' ? 'selected' : '' }}>7v7</option>
                </select>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700">Status</label>
                <select
                    name="status"
                    class="w-full rounded-xl border border-gray-300 focus:border-green-600 focus:ring-green-600 h-12 px-3 text-sm text-gray-700 bg-white outline-none"
                >
                    <option value="active" {{ old('status', $field->status) === 'active' ? 'selected' : '' }}>Active (Bookable)</option>
                    <option value="inactive" {{ old('status', $field->status) === 'inactive' ? 'selected' : '' }}>Inactive (Maintenance/Closed)</option>
                </select>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-100 pb-2">
            Media
        </h3>

        <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700">Field Image *</label>

            <div class="mt-2 flex justify-center rounded-2xl border border-dashed border-gray-300 px-6 py-10 bg-gray-50">
                <div class="text-center w-full max-w-sm">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V6m0 0l-3.75 3.75M12 6l3.75 3.75M4.5 16.5v1.125A2.625 2.625 0 007.125 20.25h9.75A2.625 2.625 0 0019.5 17.625V16.5" />
                    </svg>

                    <div class="mt-4 flex flex-col items-center text-sm leading-6 text-gray-600">
                        <label for="file-upload"
                               class="relative cursor-pointer rounded-md bg-white font-semibold text-green-600 hover:text-green-500">
                            <span>Upload a file</span>
                        </label>

                        <input id="file-upload" name="image" type="file" class="mt-3 text-sm text-gray-600" accept="image/*">

                        <p class="pl-1 text-gray-500 mt-1">or drag and drop</p>
                    </div>

                    <p class="text-xs leading-5 text-gray-500 mt-2">PNG, JPG, WEBP up to 5MB</p>
                </div>
            </div>
        </div>
    </div>

    <div class="border-t border-gray-100 pt-6 flex items-center justify-end gap-3">
        <a href="/admin/fields"
           class="rounded-xl px-6 h-12 border border-gray-200 inline-flex items-center justify-center text-sm font-medium text-gray-700 bg-white">
            Cancel
        </a>

        <button
            type="submit"
            class="bg-green-600 hover:bg-green-700 text-white rounded-xl px-8 h-12 inline-flex items-center justify-center text-sm font-medium"
        >
            Update Field
        </button>
    </div>
</form>