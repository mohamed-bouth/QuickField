@extends('layouts.public')

@section('title', 'My Reservations')

@section('content')
<div class="min-h-screen bg-gray-50 py-10">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">My Reservation History</h1>
                <p class="mt-1 text-gray-500">Track your bookings and payment progress.</p>
            </div>

            <a href="{{ route('public.fields.index') }}" class="rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white hover:bg-gray-800">
                Book New Field
            </a>
        </div>

        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Field</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Start</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">End</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Expires At</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Payment</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($reservations as $reservation)
                            <tr>
                                <td class="whitespace-nowrap px-6 py-4 font-semibold text-gray-900">
                                    <a href="{{ route('reservations.show' , $reservation->id)}}">
                                    {{ $reservation->field->name ?? 'Field unavailable' }}
                                    </a>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                    {{ optional($reservation->start_time)->format('Y-m-d H:i') }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                    {{ optional($reservation->end_time)->format('Y-m-d H:i') }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-gray-700">
                                        {{ $reservation->status }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                    {{ optional($reservation->expires_at)->format('Y-m-d H:i') ?? '-' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                    @if($reservation->payment)
                                        {{ number_format($reservation->payment->paid_amount, 2) }} / {{ number_format($reservation->payment->total_amount, 2) }}
                                    @else
                                        -
                                    @endif

                                    @if($reservation->status === 'pending' && $reservation->expires_at && $reservation->expires_at->isFuture())
                                        <div class="mt-2 flex items-center gap-2">
                                            <a
                                                href="{{ route('public.reservations.continue-payment', $reservation) }}"
                                                class="inline-flex rounded-lg bg-gray-900 px-3 py-1.5 text-xs font-semibold text-white hover:bg-gray-800"
                                            >
                                                Continue payment
                                            </a>

                                            <form method="POST" action="{{ route('public.reservations.cancel', $reservation) }}" onsubmit="return confirm('Cancel this reservation?');">
                                                @csrf
                                                @method('PATCH')
                                                <button
                                                    type="submit"
                                                    class="inline-flex rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-100"
                                                >
                                                    Cancel
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    No reservations yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $reservations->links() }}
        </div>
    </div>
</div>
@endsection
