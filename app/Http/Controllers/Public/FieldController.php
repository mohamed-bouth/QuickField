<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Field;
use App\Models\Reservation;
use Carbon\Constants\Format;

class FieldController extends Controller
{
    public function index(){
        return view('public.fields.index');
    }

    public function show(Field $field){
        return view('public.fields.show', compact('field'));
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
