@extends('layouts.public')

@section('title', 'My Reservations')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white shadow rounded-xl">

    <h1 class="text-2xl font-bold mb-4">
        Reservation Details
    </h1>

    {{-- FIELD INFO --}}
    <div class="mb-4">
        <h2 class="text-lg font-semibold">
            {{ $reservation->field->name }}
        </h2>
        <p>{{ $reservation->field->localisation }}</p>
        <p>Type: {{ $reservation->field->type }}</p>
    </div>

    <hr class="my-4">

    {{-- TIME --}}
    <div class="mb-4">
        <p><strong>Start:</strong> {{ $reservation->start_time }}</p>
        <p><strong>End:</strong> {{ $reservation->end_time }}</p>
    </div>

    {{-- STATUS --}}
    <div class="mb-4">
        <span class="px-3 py-1 rounded 
            {{ $reservation->status === 'payed' ? 'bg-green-200' : 'bg-yellow-200' }}">
            {{ $reservation->status }}
        </span>
    </div>

    {{-- PAYMENT --}}
    @if($reservation->payment)
        <div class="mb-4">
            <p><strong>Total:</strong> {{ $reservation->payment->total_amount }} €</p>
            <p><strong>Paid:</strong> {{ $reservation->payment->paid_amount }} €</p>
        </div>
    @endif

    {{-- QR CODE --}}
    @if($reservation->payment?->ticket)
        <div class="mt-6 text-center">
            <h3 class="font-semibold mb-2">Your QR Code</h3>

            {!! QrCode::size(220)->generate(
                $reservation->payment->ticket->qr_code_hash
            ) !!}
        </div>
    @endif

</div>
@endsection