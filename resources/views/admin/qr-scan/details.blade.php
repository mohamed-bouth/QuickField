@extends('layouts.admin') @section('title', 'Reservaion Details')

@section('content')
<div class="max-w-2xl mx-auto mt-10 px-4 mb-10">
    
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Reservation Details</h2>
            <p class="mt-1 text-sm text-gray-500">Verify the information before starting the match.</p>
        </div>
                    <a href="{{ route('admin.scan-ticket.index') }}" class="text-sm font-medium text-green-600 hover:text-green-500">
            <i class="fas fa-arrow-left mr-1"></i> Return to Scan
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
        
        <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <div class="bg-green-100 p-2 rounded-lg mr-3">
                    <i class="fas fa-ticket-alt text-green-600"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Numéro de Ticket</p>
                    <p class="font-bold text-gray-800 text-lg">#{{ strtoupper(substr($ticket->qr_code_hash, 0, 8)) }}</p>
                </div>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                <i class="fas fa-clock mr-1.5"></i> En attente (Pending)
            </span>
        </div>

        <div class="p-6">
            @php
                $reservation = $ticket->payment->reservation;
                $user = $reservation->user;
                $field = $reservation->field;
                $start = \Carbon\Carbon::parse($reservation->start_time);
                $end = \Carbon\Carbon::parse($reservation->end_time);
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                    <h6 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Field</h6>
                    <p class="text-gray-900 font-semibold text-lg">{{ $field->name ?? 'Terrain inconnu' }}</p>
                    <p class="text-sm text-gray-500 mt-1">Type: <span class="font-medium text-gray-700">{{ $field->type }}</span></p>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                    <h6 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">User</h6>
                    <p class="text-gray-900 font-semibold text-lg">{{ $user->name }}</p>
                    <p class="text-sm text-gray-500 mt-1"><i class="fas fa-phone-alt text-gray-400 mr-1"></i> {{ $user->phone }}</p>
                </div>
            </div>

            <hr class="border-gray-200 mb-6">

            <div class="mb-6">
                <h6 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Date and Time</h6>
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1 flex items-center p-3 border border-gray-200 rounded-lg">
                        <div>
                            <p class="text-xs text-gray-500">Date</p>
                            <p class="font-semibold text-gray-900">{{ $start->format('d / m / Y') }}</p>
                        </div>
                    </div>
                    <div class="flex-1 flex items-center p-3 border border-gray-200 rounded-lg">

                        <div>
                            <p class="text-xs text-gray-500">Match Time</p>
                            <p class="font-semibold text-gray-900">{{ $start->format('H:i') }} <span class="text-gray-400 mx-1">-</span> {{ $end->format('H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-gray-200 mb-6">

            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg border border-gray-200 mb-8">
                <div>
                    <h6 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Payment Status</h6>
                    @if($ticket->payment->status == 'finished')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check mr-1"></i>Finished
                        </span>
                    @elseif($ticket->payment->status == 'pending')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-exclamation-triangle mr-1"></i>Pending
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            {{ ucfirst($ticket->payment->status) }}
                        </span>
                    @endif
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500 mb-1">Total</p>
                    <p class="text-2xl font-bold text-green-600">{{ $ticket->payment->total_amount }} <span class="text-sm text-gray-500 font-normal">MAD</span></p>
                </div>
            </div>

            <form action="{{ route('admin.scan-ticket.confirm', $ticket->qr_code_hash) }}" method="POST">
                @csrf
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('admin.scan-ticket.index') }}" class="flex-1 flex justify-center items-center py-3 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                        <i class="fas fa-times mr-2"></i> Annuler
                    </a>
                    <button type="submit" class="flex-[2] flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                        <i class="fas fa-check-circle mr-2 text-lg"></i> Confirmer
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection