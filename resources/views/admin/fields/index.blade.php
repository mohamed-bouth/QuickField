@extends('layouts.admin')

@section('title', 'Fields Management')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Fields Management</h1>
            <p class="text-gray-500">Manage all football fields, types, statuses, and availability.</p>
        </div>

        <a href="{{ route('admin.fields.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white rounded-xl shadow-sm px-6 h-12 inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
            </svg>
            <span>Add Field</span>
        </a>
    </div>

    <div class="border-0 shadow-sm rounded-2xl bg-white overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between gap-4 bg-white">
            <div class="relative w-full max-w-sm">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input
                    type="text"
                    placeholder="Search fields by name or location..."
                    class="pl-10 pr-4 h-10 w-full rounded-xl bg-gray-50 border border-transparent focus:bg-white focus:border-green-500 outline-none"
                >
            </div>

            <div class="flex items-center gap-3">
                <button class="rounded-xl h-10 border border-gray-200 text-gray-600 bg-white shadow-sm gap-2 px-4 inline-flex items-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h18M6.75 12h10.5M10.5 19.5h3"/>
                    </svg>
                    <span>Filters</span>
                </button>

                <button class="rounded-xl h-10 border border-gray-200 text-gray-600 bg-white shadow-sm px-4 inline-flex items-center">
                    Export
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left whitespace-nowrap">
                <thead class="bg-gray-50/50 text-gray-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-semibold">ID</th>
                        <th class="px-6 py-4 font-semibold">Field Information</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold">Type</th>
                        <th class="px-6 py-4 font-semibold">Date Added</th>
                        <th class="px-6 py-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4 font-medium text-gray-500">#101</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">Stadium 1</div>
                            <div class="text-gray-500 text-xs mt-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-6-4.35-6-10.2A6 6 0 1118 10.8C18 16.65 12 21 12 21z"/>
                                    <circle cx="12" cy="10.5" r="2.25"/>
                                </svg>
                                <span>Main Complex, Paris</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100 gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/>
                                </svg>
                                <span>Active</span>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-700 bg-gray-100 px-2 py-1 rounded-md text-xs border border-gray-200">
                                7v7
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">Oct 20, 2024</td>
                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="/admin/fields/101/edit"
                                   class="px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors inline-flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.25 2.25 0 113.182 3.182L8.25 19.463 4.5 20.25l.787-3.75L16.862 4.487z"/>
                                    </svg>
                                    <span>Edit Details</span>
                                </a>

                                <a href="#"
                                   class="px-3 py-2 rounded-lg text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors inline-flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 7.5h12m-10.5 0V6a1.5 1.5 0 011.5-1.5h6A1.5 1.5 0 0116.5 6v1.5m-9 0v10.125A1.875 1.875 0 009.375 19.5h5.25A1.875 1.875 0 0016.5 17.625V7.5"/>
                                    </svg>
                                    <span>Delete Field</span>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4 font-medium text-gray-500">#102</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">Training Pitch A</div>
                            <div class="text-gray-500 text-xs mt-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-6-4.35-6-10.2A6 6 0 1118 10.8C18 16.65 12 21 12 21z"/>
                                    <circle cx="12" cy="10.5" r="2.25"/>
                                </svg>
                                <span>North Wing</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100 gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/>
                                </svg>
                                <span>Active</span>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-700 bg-gray-100 px-2 py-1 rounded-md text-xs border border-gray-200">
                                5v5
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">Oct 21, 2024</td>
                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="/admin/fields/102/edit"
                                   class="px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors inline-flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.25 2.25 0 113.182 3.182L8.25 19.463 4.5 20.25l.787-3.75L16.862 4.487z"/>
                                    </svg>
                                    <span>Edit Details</span>
                                </a>

                                <a href="#"
                                   class="px-3 py-2 rounded-lg text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors inline-flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 7.5h12m-10.5 0V6a1.5 1.5 0 011.5-1.5h6A1.5 1.5 0 0116.5 6v1.5m-9 0v10.125A1.875 1.875 0 009.375 19.5h5.25A1.875 1.875 0 0016.5 17.625V7.5"/>
                                    </svg>
                                    <span>Delete Field</span>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4 font-medium text-gray-500">#103</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">Indoor Arena B</div>
                            <div class="text-gray-500 text-xs mt-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-6-4.35-6-10.2A6 6 0 1118 10.8C18 16.65 12 21 12 21z"/>
                                    <circle cx="12" cy="10.5" r="2.25"/>
                                </svg>
                                <span>Main Complex, Paris</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                Inactive
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-700 bg-gray-100 px-2 py-1 rounded-md text-xs border border-gray-200">
                                5v5
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">Oct 22, 2024</td>
                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="/admin/fields/103/edit"
                                   class="px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors inline-flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.25 2.25 0 113.182 3.182L8.25 19.463 4.5 20.25l.787-3.75L16.862 4.487z"/>
                                    </svg>
                                    <span>Edit Details</span>
                                </a>

                                <a href="#"
                                   class="px-3 py-2 rounded-lg text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors inline-flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 7.5h12m-10.5 0V6a1.5 1.5 0 011.5-1.5h6A1.5 1.5 0 0116.5 6v1.5m-9 0v10.125A1.875 1.875 0 009.375 19.5h5.25A1.875 1.875 0 0016.5 17.625V7.5"/>
                                    </svg>
                                    <span>Delete Field</span>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4 font-medium text-gray-500">#104</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">Grand Stadium</div>
                            <div class="text-gray-500 text-xs mt-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-6-4.35-6-10.2A6 6 0 1118 10.8C18 16.65 12 21 12 21z"/>
                                    <circle cx="12" cy="10.5" r="2.25"/>
                                </svg>
                                <span>South Campus</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100 gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/>
                                </svg>
                                <span>Active</span>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-700 bg-gray-100 px-2 py-1 rounded-md text-xs border border-gray-200">
                                7v7
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">Oct 24, 2024</td>
                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="/admin/fields/104/edit"
                                   class="px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors inline-flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.25 2.25 0 113.182 3.182L8.25 19.463 4.5 20.25l.787-3.75L16.862 4.487z"/>
                                    </svg>
                                    <span>Edit Details</span>
                                </a>

                                <a href="#"
                                   class="px-3 py-2 rounded-lg text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors inline-flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 7.5h12m-10.5 0V6a1.5 1.5 0 011.5-1.5h6A1.5 1.5 0 0116.5 6v1.5m-9 0v10.125A1.875 1.875 0 009.375 19.5h5.25A1.875 1.875 0 0016.5 17.625V7.5"/>
                                    </svg>
                                    <span>Delete Field</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="p-4 sm:p-6 border-t border-gray-100 flex items-center justify-between bg-gray-50/30">
            <span class="text-sm text-gray-500 font-medium">Showing 1 to 4 of 4 results</span>

            <div class="flex items-center gap-2">
                <button class="w-9 h-9 rounded-lg border border-gray-200 inline-flex items-center justify-center text-gray-400" disabled>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                <button class="w-9 h-9 rounded-lg border border-green-600 bg-green-50 text-green-700 text-sm font-medium">
                    1
                </button>

                <button class="w-9 h-9 rounded-lg border border-gray-200 inline-flex items-center justify-center text-gray-400" disabled>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection