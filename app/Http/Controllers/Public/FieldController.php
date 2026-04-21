<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Field;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class FieldController extends Controller
{
    public function index(){
        return view('public.fields.index');
    }

    public function show(Field $field){
        $field->load([
            'reviews' => fn ($query) => $query->with('user')->latest(),
        ])->loadCount('reviews')
            ->loadAvg('reviews', 'rating');

        $canReview = false;

        if (Auth::check()) {
            $userId = Auth::id();

            $hasCompletedReservation = Reservation::where('user_id', $userId)
                ->where('field_id', $field->id)
                ->where('status', 'completed')
                ->exists();

            $alreadyReviewed = $field->reviews()
                ->where('user_id', $userId)
                ->exists();

            $canReview = $hasCompletedReservation && ! $alreadyReviewed;
        }

        return view('public.fields.show', compact('field', 'canReview'));
    }

    public function events(Request $request , Field $field){
        $reservations = Reservation::where('field_id' , $field->id)->get();

        return response()->json(
            $reservations->map(function ($reservation) {
                return [
                    'id' => $reservation->id,
                    'title' => 'Reserved',
                    'start' => $reservation->start_time,
                    'end' => $reservation->end_time,
                    'classNames' => ['reservation-' . $reservation->status],

                    'extendedProps' => [
                        'field_id' => $reservation->field_id,
                        'user_id' => $reservation->user_id,
                        'status' => $reservation->status,
                    ],
                ];
            })
        );
    }   
}
