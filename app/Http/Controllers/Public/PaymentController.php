<?php

namespace App\Http\Controllers\Public;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;

class PaymentController extends Controller
{
    public function createIntent(Request $request)
    {
        $validated = $request->validate([
            'reservation_id' => ['required', 'integer', 'exists:reservations,id'],
        ]);

        $reservation = Reservation::with('field.prices')
            ->where('id', $validated['reservation_id'])
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        if ($reservation->status !== 'pending') {
            return response()->json([
                'message' => 'Only pending reservations can be paid.',
            ], 422);
        }

        $dayName = strtolower(Carbon::parse($reservation->start_time)->format('l'));
        $price = $reservation->field->prices
            ->firstWhere('day_of_week', $dayName)?->price;

        if ($price === null) {
            return response()->json([
                'message' => 'Price for this day is not configured.',
            ], 422);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $amount = (int) round(((float) $price / 2) * 100);

        if ($amount < 50) {
            return response()->json([
                'message' => 'Deposit amount is too low for Stripe. Please set a higher field price.',
            ], 422);
        }

        try {
            $intent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'eur',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);
        } catch (ApiErrorException $e) {
            report($e);

            return response()->json([
                'message' => 'Unable to create payment intent. Please verify amount and Stripe configuration.',
            ], 422);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'Unexpected payment error. Please try again.',
            ], 500);
        }

        return response()->json([
            'clientSecret' => $intent->client_secret
        ]);
    }

    public function confirm(Request $request)
    {
        $validated = $request->validate([
            'reservation_id' => ['required', 'integer', 'exists:reservations,id'],
            'payment_intent_id' => ['required', 'string'],
        ]);

        $reservation = Reservation::with('field.prices')
            ->where('id', $validated['reservation_id'])
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $dayName = strtolower(Carbon::parse($reservation->start_time)->format('l'));
        $price = $reservation->field->prices
            ->firstWhere('day_of_week', $dayName)?->price;

        if ($price === null) {
            return response()->json([
                'message' => 'Price for this day is not configured.',
            ], 422);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $intent = PaymentIntent::retrieve($validated['payment_intent_id']);
        } catch (ApiErrorException $e) {
            report($e);

            return response()->json([
                'message' => 'Unable to verify payment status with Stripe.',
            ], 422);
        }

        if ($intent->status !== 'succeeded') {
            return response()->json([
                'message' => 'Payment is not completed yet.',
            ], 422);
        }

        $paidAmount = round(((float) $price / 2), 2);

        DB::transaction(function () use ($reservation, $price, $paidAmount) {
            if ($reservation->status === 'pending') {
                $reservation->update(['status' => 'payed']);
            }

            Payment::updateOrCreate(
                ['reservation_id' => $reservation->id],
                [
                    'total_amount' => round((float) $price, 2),
                    'paid_amount' => $paidAmount,
                    'status' => 'pending',
                ]
            );
        });

        return response()->json([
            'message' => 'Payment confirmed successfully.',
        ]);
    }
}
