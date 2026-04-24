@extends('layouts.admin')

@section('title', 'Fields Management')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Fields Management</h1>
            <p class="text-gray-500">Manage all football fields, types, statuses, and availability.</p>
        </div>

        @if(auth()->user()?->hasRole('field_manager'))
            <a href="{{ route('admin.fields.create') }}"
               class="bg-green-600 hover:bg-green-700 text-white rounded-xl shadow-sm px-6 h-12 inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
                </svg>
                <span>Add Field</span>
            </a>
        @endif
    </div>

    <livewire:admin.fields.search />

    @if(auth()->user()?->hasRole('super_admin'))
        <div class="space-y-3">
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Field Validation Requests</h2>
            <p class="text-gray-500">Approve or reject newly submitted fields from managers.</p>

            <livewire:admin.fields.validation />
        </div>
    @endif
</div>
@endsection