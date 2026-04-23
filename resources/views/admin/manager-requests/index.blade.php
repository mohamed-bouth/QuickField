@extends('layouts.admin')

@section('title', 'Manager Account Requests')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Manager Account Requests</h1>
            <p class="text-gray-500">Review pending manager registration requests and decide to approve or reject.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="mb-5 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-end">
            <form action="{{ route('admin.manager-requests.index') }}" method="GET" class="flex items-end gap-3">
                <div>
                    <label for="status" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Status</label>
                    <select
                        id="status"
                        name="status"
                        class="h-11 rounded-xl border border-gray-200 px-3 text-sm text-gray-900 outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-500/20"
                    >
                        <option value="">All statuses</option>
                        @foreach($allowedStatuses as $status)
                            <option value="{{ $status }}" @selected($selectedStatus === $status)>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="h-11 rounded-xl bg-green-600 px-4 text-sm font-semibold text-white hover:bg-green-700">
                        Filter
                    </button>
                    <a href="{{ route('admin.manager-requests.index') }}" class="h-11 rounded-xl border border-gray-200 px-4 text-sm font-semibold text-gray-700 inline-flex items-center hover:bg-gray-50">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-wider text-gray-500">
                        <th class="px-3 py-3">Code</th>
                        <th class="px-3 py-3">Name</th>
                        <th class="px-3 py-3">Email</th>
                        <th class="px-3 py-3">Phone</th>
                        <th class="px-3 py-3">Status</th>
                        <th class="px-3 py-3">Requested At</th>
                        <th class="px-3 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($requests as $requestItem)
                        <tr>
                            <td class="px-3 py-3 font-medium text-gray-900">{{ $requestItem->request_code }}</td>
                            <td class="px-3 py-3 text-gray-700">{{ $requestItem->name }}</td>
                            <td class="px-3 py-3 text-gray-700">{{ $requestItem->email }}</td>
                            <td class="px-3 py-3 text-gray-700">{{ $requestItem->phone }}</td>
                            <td class="px-3 py-3">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $requestItem->status === 'approved' ? 'bg-green-100 text-green-700' : ($requestItem->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ $requestItem->status }}
                                </span>
                            </td>
                            <td class="px-3 py-3 text-gray-700">{{ $requestItem->created_at?->format('Y-m-d H:i') }}</td>
                            <td class="px-3 py-3">
                                @if($requestItem->status === 'pending')
                                    <div class="flex flex-col gap-2">
                                        <form action="{{ route('admin.manager-requests.approve', $requestItem) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="rounded-lg bg-green-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-green-700">
                                                Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.manager-requests.reject', $requestItem) }}" method="POST" class="space-y-2">
                                            @csrf
                                            @method('PATCH')
                                            <input
                                                type="text"
                                                name="rejection_reason"
                                                placeholder="Reason (optional)"
                                                class="w-full rounded-lg border border-gray-200 px-2.5 py-1.5 text-xs text-gray-700"
                                            >
                                            <button type="submit" class="rounded-lg bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-700">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="space-y-1 text-xs text-gray-500">
                                        <p>Reviewed by: {{ $requestItem->reviewer->name ?? '-' }}</p>
                                        <p>Processed: {{ $requestItem->processed_at?->format('Y-m-d H:i') ?? '-' }}</p>
                                        @if($requestItem->status === 'approved')
                                            <p>Account: {{ $requestItem->user && $requestItem->user->status === 'active' ? 'active' : 'inactive' }}</p>
                                        @endif
                                        @if($requestItem->status === 'rejected' && $requestItem->rejection_reason)
                                            <p>Reason: {{ $requestItem->rejection_reason }}</p>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-3 py-8 text-center text-gray-500">No manager account requests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $requests->links() }}
        </div>
    </div>
</div>
@endsection
