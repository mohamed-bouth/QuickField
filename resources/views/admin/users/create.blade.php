@extends('layouts.admin')

@section('title', 'Create New User')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <div class="flex items-center gap-4">
        <a href="/admin/users"
           class="p-2 -ml-2 text-gray-400 hover:text-gray-900 rounded-full hover:bg-gray-100 transition-colors inline-block">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>

        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Create New User</h1>
            <p class="text-gray-500">Fill in the information below to add a new user to your system.</p>
        </div>
    </div>

    <div class="border-0 shadow-sm rounded-2xl bg-white overflow-hidden">
        <div class="p-8">
            @include('admin.users.partials.form')
        </div>
    </div>
</div>
@endsection