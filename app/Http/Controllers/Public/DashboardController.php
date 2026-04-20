<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Field;

class DashboardController extends Controller
{
    public function index(){
        $today = strtolower(now()->englishDayOfWeek); 

        $topFields = Field::query()
            ->withWhereHas('prices', fn ($q) => $q->where('day_of_week' , $today))
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->limit(3)
            ->get();
        return view('public.dashboard.index' , compact('topFields'));
    }
}
