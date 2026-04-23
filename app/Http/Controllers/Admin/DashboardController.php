<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now();

        $currentMonthStart = $now->copy()->startOfMonth();
        $currentMonthEnd = $now->copy()->endOfMonth();

        $previousMonthStart = $now->copy()->subMonthNoOverflow()->startOfMonth();
        $previousMonthEnd = $now->copy()->subMonthNoOverflow()->endOfMonth();

        $currentProfit = (float) Payment::query()
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->sum('paid_amount');

        $previousProfit = (float) Payment::query()
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->sum('paid_amount');

        $currentUsers = (int) User::query()
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->count();

        $previousUsers = (int) User::query()
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->count();

        $currentReservations = (int) Reservation::query()
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->count();

        $previousReservations = (int) Reservation::query()
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->count();

        $currentAverageRating = (float) Review::query()
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->avg('rating');

        $previousAverageRating = (float) Review::query()
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->avg('rating');

        $topReservedCompletedFields = Field::query()
            ->withCount([
                'reservations as completed_reservations_count' => function ($query) {
                    $query->where('status', 'completed');
                },
            ])
            ->having('completed_reservations_count', '>', 0)
            ->orderByDesc('completed_reservations_count')
            ->limit(3)
            ->get();

        $topRatedFields = Field::query()
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->whereHas('reviews')
            ->orderByDesc('reviews_avg_rating')
            ->orderByDesc('reviews_count')
            ->limit(3)
            ->get();

        $stats = [
            [
                'label' => 'Monthly Profits',
                'value' => number_format($currentProfit, 2),
                'suffix' => ' EUR',
                'growth' => $this->calculateGrowth($currentProfit, $previousProfit),
            ],
            [
                'label' => 'New Accounts This Month',
                'value' => number_format($currentUsers),
                'suffix' => '',
                'growth' => $this->calculateGrowth($currentUsers, $previousUsers),
            ],
            [
                'label' => 'Monthly Reservations',
                'value' => number_format($currentReservations),
                'suffix' => '',
                'growth' => $this->calculateGrowth($currentReservations, $previousReservations),
            ],
            [
                'label' => 'Monthly Avg Rating',
                'value' => number_format($currentAverageRating, 2),
                'suffix' => ' / 5',
                'growth' => $this->calculateGrowth($currentAverageRating, $previousAverageRating),
            ],
        ];

        return view('admin.dashboard.index', [
            'stats' => $stats,
            'topReservedCompletedFields' => $topReservedCompletedFields,
            'topRatedFields' => $topRatedFields,
            'monthLabel' => $currentMonthStart->format('F Y'),
            'previousMonthLabel' => $previousMonthStart->format('F Y'),
        ]);
    }

    private function calculateGrowth(float|int $current, float|int $previous): float
    {
        if ((float) $previous === 0.0) {
            return (float) $current > 0 ? 100.0 : 0.0;
        }

        return (($current - $previous) / $previous) * 100;
    }
}
