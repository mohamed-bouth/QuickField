<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request){
        $reservations = Reservation::with(['user', 'field'])
            ->when($request->filled('date'), function ($query) use ($request) {
                $query->whereDate('start_time', $request->date);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.reservations.index', compact('reservations'));
    }

    public function confirm(Reservation $reservation)
    {
        if ($reservation->status !== 'payed') {
            return back()->with('error', 'Only payed reservations can be confirmed.');
        }

        $reservation->update([
            'status' => 'confirmed',
        ]);

        return back()->with('success', 'Reservation confirmed successfully.');
    }

    public function cancel(Reservation $reservation)
    {
        if ($reservation->status !== 'payed') {
            return back()->with('error', 'Only payed reservations can be cancelled.');
        }

        $reservation->update([
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'Reservation cancelled successfully.');
    }
}
