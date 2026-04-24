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
        $user = $request->user();

        if ($user->hasRole('super_admin')) {
            return $this->superAdminDashboard();
        }

        if ($user->hasRole('field_manager')) {
            return $this->fieldManagerDashboard($user);
        }

        if ($user->hasRole('field_guard')) {
            return $this->fieldGuardDashboard($user);
        }

        abort(403);
    }

    private function superAdminDashboard()
    {
        $now = Carbon::now();
        [$currentMonthStart, $currentMonthEnd, $previousMonthStart, $previousMonthEnd] = $this->resolveMonthRanges($now);

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
                'suffix' => ' MAD',
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
            'dashboardRole' => 'super_admin',
            'stats' => $stats,
            'topReservedFields' => $topReservedCompletedFields,
            'topRatedFields' => $topRatedFields,
            'monthLabel' => $currentMonthStart->format('F Y'),
            'previousMonthLabel' => $previousMonthStart->format('F Y'),
        ]);
    }

    private function fieldManagerDashboard(User $manager)
    {
        $now = Carbon::now();
        [$currentMonthStart, $currentMonthEnd, $previousMonthStart, $previousMonthEnd] = $this->resolveMonthRanges($now);

        $fieldIds = $manager->fields()->pluck('id');

        $currentProfit = (float) Payment::query()
            ->whereHas('reservation', function ($query) use ($fieldIds) {
                $query->whereIn('field_id', $fieldIds);
            })
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->sum('paid_amount');

        $previousProfit = (float) Payment::query()
            ->whereHas('reservation', function ($query) use ($fieldIds) {
                $query->whereIn('field_id', $fieldIds);
            })
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->sum('paid_amount');

        $totalReservations = (int) Reservation::query()
            ->whereIn('field_id', $fieldIds)
            ->whereNotIn('status', ['cancelled', 'refuesed'])
            ->count();

        $totalFields = (int) $fieldIds->count();

        $averageRating = (float) Review::query()
            ->whereIn('field_id', $fieldIds)
            ->avg('rating');

        $topReservedFields = Field::query()
            ->whereIn('id', $fieldIds)
            ->withCount([
                'reservations as reservations_count' => function ($query) {
                    $query->whereNotIn('status', ['cancelled', 'refuesed']);
                },
            ])
            ->orderByDesc('reservations_count')
            ->limit(3)
            ->get();

        $topRatedFields = Field::query()
            ->whereIn('id', $fieldIds)
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->orderByDesc('reviews_count')
            ->limit(3)
            ->get();

        $stats = [
            [
                'label' => 'Monthly Profits',
                'value' => number_format($currentProfit, 2),
                'suffix' => ' MAD',
                'growth' => $this->calculateGrowth($currentProfit, $previousProfit),
            ],
            [
                'label' => 'Total Reservations',
                'value' => number_format($totalReservations),
                'suffix' => '',
            ],
            [
                'label' => 'Total Fields',
                'value' => number_format($totalFields),
                'suffix' => '',
            ],
            [
                'label' => 'Average Rating',
                'value' => number_format($averageRating, 2),
                'suffix' => ' / 5',
            ],
        ];

        return view('admin.dashboard.index', [
            'dashboardRole' => 'field_manager',
            'stats' => $stats,
            'topReservedFields' => $topReservedFields,
            'topRatedFields' => $topRatedFields,
            'monthLabel' => $currentMonthStart->format('F Y'),
            'previousMonthLabel' => $previousMonthStart->format('F Y'),
        ]);
    }

    private function fieldGuardDashboard(User $guard)
    {
        $now = Carbon::now();
        $todayStart = $now->copy()->startOfDay();
        $todayEnd = $now->copy()->endOfDay();
        $nextThreeHours = $now->copy()->addHours(3);

        $guardFieldIds = $guard->guardedFields()->pluck('fields.id');

        $todayReservationsCount = (int) Reservation::query()
            ->whereIn('field_id', $guardFieldIds)
            ->whereBetween('start_time', [$todayStart, $todayEnd])
            ->whereNotIn('status', ['cancelled', 'refuesed'])
            ->count();

        $moneyToCollectToday = (float) Payment::query()
            ->whereHas('reservation', function ($query) use ($guardFieldIds, $todayStart, $todayEnd) {
                $query->whereIn('field_id', $guardFieldIds)
                    ->whereBetween('start_time', [$todayStart, $todayEnd])
                    ->whereIn('status', ['payed', 'confirmed', 'completed']);
            })
            ->get()
            ->sum(function (Payment $payment) {
                $remaining = (float) $payment->total_amount - (float) $payment->paid_amount;

                return $remaining > 0 ? $remaining : 0;
            });

        $averageRating = (float) Review::query()
            ->whereIn('field_id', $guardFieldIds)
            ->avg('rating');

        $latestReview = Review::query()
            ->with(['user', 'field'])
            ->whereIn('field_id', $guardFieldIds)
            ->latest()
            ->first();

        $upcomingReservations = Reservation::query()
            ->with(['user', 'field', 'payment'])
            ->whereIn('field_id', $guardFieldIds)
            ->whereBetween('start_time', [$now, $nextThreeHours])
            ->whereNotIn('status', ['cancelled', 'refuesed'])
            ->orderBy('start_time')
            ->limit(3)
            ->get();

        $guardFields = $guard->guardedFields()
            ->with('user:id,name')
            ->orderBy('name')
            ->get();

        $stats = [
            [
                'label' => 'Reservations Today',
                'value' => number_format($todayReservationsCount),
                'suffix' => '',
            ],
            [
                'label' => 'Remaining To Collect',
                'value' => number_format($moneyToCollectToday, 2),
                'suffix' => ' MAD',
            ],
            [
                'label' => 'Average Field Rating',
                'value' => number_format($averageRating, 2),
                'suffix' => ' / 5',
            ],
        ];

        return view('admin.dashboard.index', [
            'dashboardRole' => 'field_guard',
            'stats' => $stats,
            'latestReview' => $latestReview,
            'upcomingReservations' => $upcomingReservations,
            'guardFields' => $guardFields,
            'nextThreeHoursLabel' => $nextThreeHours->format('H:i'),
        ]);
    }

    private function resolveMonthRanges(Carbon $now): array
    {
        $currentMonthStart = $now->copy()->startOfMonth();
        $currentMonthEnd = $now->copy()->endOfMonth();

        $previousMonthReference = $now->copy()->subMonthNoOverflow();
        $previousMonthStart = $previousMonthReference->copy()->startOfMonth();
        $previousMonthEnd = $previousMonthReference->copy()->endOfMonth();

        return [$currentMonthStart, $currentMonthEnd, $previousMonthStart, $previousMonthEnd];
    }

    private function calculateGrowth(float|int $current, float|int $previous): float
    {
        if ((float) $previous === 0.0) {
            return (float) $current > 0 ? 100.0 : 0.0;
        }

        return (($current - $previous) / $previous) * 100;
    }
}
