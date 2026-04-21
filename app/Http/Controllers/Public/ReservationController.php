<?php

namespace App\Http\Controllers\Public;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\Reservation;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function takeHour(Request $request , $id){
        $start_time = \Carbon\Carbon::parse($request->start)->format('Y-m-d\TH:i');
        $end_time = \Carbon\Carbon::parse($request->end)->format('Y-m-d\TH:i');

        $now = Carbon::now(+1)->format('Y-m-d\TH:i');

        if($start_time < $now){
            return redirect()->route('public.fields.show', ['field' => $id])->with(['error' => 'this date is in past !']);
        };

        $dayName = strtolower(Carbon::now()->format('l'));
        $field = Field::with(['prices' => function ($query) use ($dayName) {
                $query->where('day_of_week', $dayName);
            }])->where('id', $id)
            ->firstOrFail();

        $user = $request->user();

        $reservation = Reservation::create([
            'field_id' => $field->id,
            'user_id' => $request->user()->id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status' => 'pending',
            'expires_at' => now()->addMinute(5)
        ]);

        return view('public.fields.payment' , compact('field', 'user' , 'reservation'));
    }
}
