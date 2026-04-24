<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request){
        $user = $request->user();
        $allowedStatuses = ['pending', 'payed', 'confirmed', 'cancelled'];
        $selectedStatus = $request->input('status');

        $reservations = Reservation::with(['user', 'field'])
            ->when(! $user->hasRole('super_admin'), function ($query) use ($user) {
                $query->whereHas('field', function ($fieldQuery) use ($user) {
                    $fieldQuery->where('user_id', $user->id);
                });
            })
            ->when($request->filled('date'), function ($query) use ($request) {
                $query->whereDate('start_time', $request->date);
            })
            ->when(in_array($selectedStatus, $allowedStatuses, true), function ($query) use ($selectedStatus) {
                $query->where('status', $selectedStatus);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.reservations.index', compact('reservations', 'allowedStatuses', 'selectedStatus'));
    }

    public function confirm(Request $request, Reservation $reservation)
    {
        abort_unless($this->canAccessReservation($request, $reservation), 403);

        if ($reservation->status !== 'payed') {
            return back()->with('error', 'Only payed reservations can be confirmed.');
        }

        $reservation->update([
            'status' => 'confirmed',
        ]);

        return back()->with('success', 'Reservation confirmed successfully.');
    }

    public function cancel(Request $request, Reservation $reservation)
    {
        abort_unless($this->canAccessReservation($request, $reservation), 403);

        if ($reservation->status !== 'payed') {
            return back()->with('error', 'Only payed reservations can be cancelled.');
        }

        $reservation->update([
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'Reservation cancelled successfully.');
    }

    private function canAccessReservation(Request $request, Reservation $reservation): bool
    {
        if ($request->user()->hasRole('super_admin')) {
            return true;
        }

        return (int) $reservation->field()->value('user_id') === (int) $request->user()->id;
    }
}
