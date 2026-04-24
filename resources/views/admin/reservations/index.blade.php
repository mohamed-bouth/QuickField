@extends('layouts.admin')

@section('title', 'Reservations Management')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Reservations Management</h1>
                <p class="text-gray-500">Search reservations by date and validate paid bookings.</p>
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

                <form action="{{ route('admin.reservations.index') }}" method="GET" class="flex flex-col sm:flex-row items-start sm:items-end gap-3">
                    <div>
                        <label for="date" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Reservation date</label>
                        <input
                            id="date"
                            name="date"
                            type="date"
                            value="{{ request('date') }}"
                            class="h-11 rounded-xl border border-gray-200 px-3 text-sm text-gray-900 outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-500/20"
                        >
                    </div>

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
                            Search
                        </button>
                        <a href="{{ route('admin.reservations.index') }}" class="h-11 rounded-xl border border-gray-200 px-4 text-sm font-semibold text-gray-700 inline-flex items-center hover:bg-gray-50">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-wider text-gray-500">
                            <th class="px-3 py-3">ID</th>
                            <th class="px-3 py-3">Player</th>
                            <th class="px-3 py-3">Field</th>
                            <th class="px-3 py-3">Start</th>
                            <th class="px-3 py-3">End</th>
                            <th class="px-3 py-3">Status</th>
                            <th class="px-3 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($reservations as $reservation)
                            <tr>
                                <td class="px-3 py-3 font-medium text-gray-900">{{ $reservation->id }}</td>
                                <td class="px-3 py-3 text-gray-700">{{ $reservation->user->name ?? 'Unknown' }}</td>
                                <td class="px-3 py-3 text-gray-700">{{ $reservation->field->name ?? 'Unknown' }}</td>
                                <td class="px-3 py-3 text-gray-700">{{ $reservation->start_time }}</td>
                                <td class="px-3 py-3 text-gray-700">{{ $reservation->end_time }}</td>
                                <td class="px-3 py-3">
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $reservation->status === 'confirmed' ? 'bg-green-100 text-green-700' : ($reservation->status === 'cancelled' ? 'bg-red-100 text-red-700' : ($reservation->status === 'payed' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700')) }}">
                                        {{ $reservation->status }}
                                    </span>
                                </td>
                                <td class="px-3 py-3">
                                    @hasanyrole('field_manager|super_admin')
                                    @if($reservation->status === 'payed')
                                        <div class="flex items-center gap-2">
                                            <form action="{{ route('admin.reservations.confirm', $reservation) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="rounded-lg bg-green-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-green-700">
                                                    Confirm
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.reservations.cancel', $reservation) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="rounded-lg bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-700">
                                                    Cancel
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400">No action</span>
                                    @endif
                                    @endhasanyrole
                                    @role('field_guard')
                                        <span class="text-xs text-gray-400">No action</span>
                                    @endrole
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-3 py-8 text-center text-gray-500">No reservations found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $reservations->links() }}
            </div>
        </div>
    </div>
@endsection