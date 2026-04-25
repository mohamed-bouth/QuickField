@extends('layouts.admin')

@section('title', 'Users Management')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Users Management</h1>
            <p class="text-gray-500">Manage all users, roles, and permissions.</p>
        </div>

        <a href="{{ route('admin.users.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white rounded-xl shadow-sm px-6 h-12 inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
            </svg>
            <span>Add User</span>
        </a>
    </div>
    @can('users.blacklist.manage')
        <livewire:admin.users.search />
    @endcan
@endsection