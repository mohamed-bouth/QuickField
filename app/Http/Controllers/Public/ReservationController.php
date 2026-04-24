<?php

namespace App\Http\Controllers\Public;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\Reservation;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function history(Request $request)
    {
        Reservation::expirePendingReservations();

        $user = $request->user();

        $reservations = $user->reservations()
            ->with(['field', 'payment'])
            ->latest('created_at')
            ->paginate(12);

        return view('public.reservations.history', compact('reservations'));
    }

    public function continuePayment(Request $request, Reservation $reservation)
    {
        Reservation::expirePendingReservations();

        abort_unless((int) $reservation->user_id === (int) $request->user()->id, 403);

        if (
            $reservation->status !== 'pending'
            || !$reservation->expires_at
            || $reservation->expires_at->lte(now())
        ) {
            return redirect()
                ->route('public.reservations.history')
                ->with('error', 'This reservation can no longer be paid.');
        }

        $dayName = strtolower($reservation->start_time->format('l'));
        $field = Field::with(['prices' => function ($query) use ($dayName) {
                $query->where('day_of_week', $dayName);
            }])->findOrFail($reservation->field_id);

        $user = $request->user();

        return view('public.fields.payment', compact('field', 'user', 'reservation'));
    }

    public function cancel(Request $request, Reservation $reservation)
    {
        Reservation::expirePendingReservations();

        abort_unless((int) $reservation->user_id === (int) $request->user()->id, 403);

        if ($reservation->status !== 'pending') {
            return redirect()
                ->route('public.reservations.history')
                ->with('error', 'Only pending reservations can be cancelled.');
        }

        $reservation->update([
            'status' => 'cancelled',
            'expires_at' => null,
        ]);

        return redirect()
            ->route('public.reservations.history')
            ->with('success', 'Reservation cancelled successfully.');
    }

    public function takeHour(Request $request , $id){
        Reservation::expirePendingReservations();

        $start_time = Carbon::parse($request->start)
            ->setTimezone(config('app.timezone'))
            ->startOfMinute();
        $end_time = Carbon::parse($request->end)
            ->setTimezone(config('app.timezone'))
            ->startOfMinute();

        $now = Carbon::now();

        if($start_time->lt($now)){
            return redirect()->route('public.fields.show', ['field' => $id])->with(['error' => 'this date is in past !']);
        };

        if ($end_time->lte($start_time)) {
            return redirect()->route('public.fields.show', ['field' => $id])->with(['error' => 'Invalid reservation time range.']);
        }


        $dayName = strtolower($start_time->format('l'));
        $field = Field::with(['prices' => function ($query) use ($dayName) {
                $query->where('day_of_week', $dayName);
            }])->where('id', $id)
            ->firstOrFail();

        $hasConflict = Reservation::query()
            ->where('field_id', $field->id)
            ->activeBlocking()
            ->where(function ($query) use ($start_time, $end_time) {
                $query->where('start_time', '<', $end_time)
                    ->where('end_time', '>', $start_time);
            })
            ->exists();


        if ($hasConflict) {
            return redirect()->route('public.fields.show', ['field' => $id])->with(['error' => 'This slot is no longer available.']);
        }

        $user = $request->user();

        $reservation = Reservation::create([
            'field_id' => $field->id,
            'user_id' => $request->user()->id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status' => 'pending',
            'expires_at' => now()->addMinutes(10)
        ]);

        return view('public.fields.payment' , compact('field', 'user' , 'reservation'));
    }
}
