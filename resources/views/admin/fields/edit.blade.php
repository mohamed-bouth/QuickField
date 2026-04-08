@extends('layouts.admin')

@section('title', 'Update Field')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <div class="flex items-center gap-4">
        <a href="/admin/fields"
           class="p-2 -ml-2 text-gray-400 hover:text-gray-900 rounded-full hover:bg-gray-100 transition-colors inline-block">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>

        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Update Field</h1>
            <p class="text-gray-500">Edit the details for this football pitch.</p>
        </div>
    </div>

    <div class="border-0 shadow-sm rounded-2xl bg-white overflow-hidden">
        <div class="p-8">
            <form action="#" method="POST" enctype="multipart/form-data" class="space-y-8">
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-100 pb-2">
                        General Information
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">Field Name *</label>
                            <input
                                type="text"
                                name="name"
                                value="Field #1"
                                required
                                placeholder="e.g. Main Stadium 5v5"
                                class="w-full rounded-xl border border-gray-300 focus:border-green-600 focus:ring-green-600 h-12 px-4 text-sm text-gray-700 outline-none"
                            >
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">Localisation *</label>
                            <input
                                type="text"
                                name="localisation"
                                value="East Wing, Sport Complex"
                                required
                                placeholder="e.g. North Complex, Paris"
                                class="w-full rounded-xl border border-gray-300 focus:border-green-600 focus:ring-green-600 h-12 px-4 text-sm text-gray-700 outline-none"
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
                        >Premium artificial grass, recently renovated surface.</textarea>
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
                                <option value="5v5" selected>5v5 (Five-a-side)</option>
                                <option value="7v7">7v7 (Seven-a-side)</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">Status</label>
                            <select
                                name="status"
                                class="w-full rounded-xl border border-gray-300 focus:border-green-600 focus:ring-green-600 h-12 px-3 text-sm text-gray-700 bg-white outline-none"
                            >
                                <option value="active" selected>Active (Bookable)</option>
                                <option value="inactive">Inactive (Maintenance/Closed)</option>
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
                                <div class="mb-4 relative rounded-xl overflow-hidden aspect-video">
                                    <img
                                        src="https://images.unsplash.com/photo-1579952363873-27f3bade9f55?q=80&w=800&auto=format&fit=crop"
                                        alt="Preview"
                                        class="object-cover w-full h-full"
                                    >
                                </div>

                                <div class="mt-4 flex flex-col items-center text-sm leading-6 text-gray-600">
                                    <label for="file-upload"
                                           class="relative cursor-pointer rounded-md bg-white font-semibold text-green-600 hover:text-green-500">
                                        <span>Upload a file</span>
                                    </label>

                                    <input id="file-upload" name="image_url" type="file" class="mt-3 text-sm text-gray-600" accept="image/*">

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
        </div>
    </div>
</div>
@endsection