@extends('layouts.public')

@section('title', 'Checkout')

@section('content')

<div class="min-h-screen bg-gray-50 py-10">

    <div class="mx-auto grid max-w-6xl grid-cols-1 gap-10 px-4 lg:grid-cols-3">

        
        <div class="lg:col-span-2 space-y-6">

            <!-- HEADER -->
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">
                    Confirm & Pay
                </h1>
                <p class="text-gray-500">
                    Secure your booking by paying 50% deposit
                </p>
            </div>

            
            <div class="rounded-3xl bg-white p-6 shadow-sm space-y-6">

                <h2 class="text-xl font-bold text-gray-900">
                    Booking Summary
                </h2>

                <!-- FIELD -->
                <div class="flex items-center justify-between border-b pb-4">
                    <span class="text-gray-500">Field</span>
                    <span class="font-bold text-gray-900">{{ $field->name }}</span>
                </div>

                <!-- DATE -->
                <div class="flex items-center justify-between border-b pb-4">
                    <span class="text-gray-500">Date</span>
                    <span class="font-bold text-gray-900">
                        {{ \Carbon\Carbon::parse($reservation->start_time)->format('Y-m-d') }}
                    </span>
                </div>

                <!-- TIME -->
                <div class="flex items-center justify-between border-b pb-4">
                    <span class="text-gray-500">Time</span>
                    <span class="font-bold text-gray-900">
                        {{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}
                        -
                        {{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}
                    </span>
                </div>

                <!-- LOCATION -->
                <div class="flex items-center justify-between">
                    <span class="text-gray-500">Location</span>
                    <span class="font-bold text-gray-900">{{ $field->localisation }}</span>
                </div>

            </div>


            <div class="rounded-3xl bg-white p-6 shadow-sm">

                <h2 class="mb-4 text-xl font-bold text-gray-900">
                    Payment Method
                </h2>

                <form id="payment-form" class="space-y-6">

                    <!-- STRIPE ELEMENT -->
                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-700">
                            Card Details
                        </label>

                        <div id="card-element"
                             class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                        </div>
                    </div>

                    <!-- BUTTON -->
                    <button
                        id="pay-btn"
                        class="w-full rounded-2xl bg-gray-900 py-4 text-lg font-bold text-white hover:bg-gray-800"
                    >
                        Pay ${{ number_format($field->prices[0]->price / 2, 2) }}
                    </button>

                    <p class="text-center text-xs text-gray-400">
                        Secure payment powered by Stripe
                    </p>

                </form>

            </div>
        </div>


        <div class="lg:col-span-1">

            <div class="sticky top-20 rounded-3xl bg-white shadow-xl overflow-hidden">

                <img
                    src="{{ Storage::disk('r2')->url($field->image_path) }}"
                    class="h-48 w-full object-cover"
                >

                <div class="p-6 space-y-4">

                    <!-- USER INFO (READ ONLY) -->
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">User</h3>
                        <p class="text-gray-600">{{ auth()->user()->name }}</p>
                        <p class="text-gray-600">{{ auth()->user()->email }}</p>
                        <p class="text-gray-600">{{ auth()->user()->phone }}</p>
                    </div>

                    <hr>

                    <!-- PRICE -->
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span>Total</span>
                            <span>${{ number_format($field->prices[0]->price, 2) }}</span>
                        </div>

                        <div class="flex justify-between font-bold text-green-700">
                            <span>Now (50%)</span>
                            <span>${{ number_format($field->prices[0]->price / 2, 2) }}</span>
                        </div>

                        <div class="flex justify-between text-sm text-gray-500">
                            <span>Remaining</span>
                            <span>${{ number_format($field->prices[0]->price / 2, 2) }}</span>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

<div
    id="payment-config"
    data-stripe-key="{{ config('services.stripe.key') }}"
    data-reservation-id="{{ $reservation->id }}"
></div>

<script src="https://js.stripe.com/v3/"></script>

<script>
const paymentConfig = document.getElementById("payment-config");
const stripeKey = paymentConfig?.dataset?.stripeKey || "";

if (!stripeKey) {
    throw new Error('Stripe publishable key is missing. Set STRIPE_KEY in your environment.');
}

const stripe = Stripe(stripeKey);
const elements = stripe.elements();
const reservationId = Number(paymentConfig?.dataset?.reservationId || 0);

const card = elements.create("card");
card.mount("#card-element");

async function createIntent() {
    let res = await fetch("/payment/create-intent", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            reservation_id: reservationId
        })
    });

    if (!res.ok) {
        const err = await res.json().catch(() => ({}));
        throw new Error(err.message || "Unable to create payment intent.");
    }

    return await res.json();
}

async function confirmPayment(paymentIntentId) {
    let res = await fetch("/payment/confirm", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            reservation_id: reservationId,
            payment_intent_id: paymentIntentId
        })
    });

    if (!res.ok) {
        const err = await res.json().catch(() => ({}));
        throw new Error(err.message || "Unable to save payment in database.");
    }

    return await res.json();
}

document.getElementById("payment-form").addEventListener("submit", async (e) => {
    e.preventDefault();

    const payBtn = document.getElementById("pay-btn");
    payBtn.disabled = true;
    payBtn.classList.add("opacity-60", "cursor-not-allowed");

    try {
        let { clientSecret } = await createIntent();

        let result = await stripe.confirmCardPayment(clientSecret, {
            payment_method: {
                card: card
            }
        });

        if (result.error) {
            alert(result.error.message || "Payment failed.");
        } else if (result.paymentIntent.status === "succeeded") {
            await confirmPayment(result.paymentIntent.id);
            window.location.href = "{{ route('public.payment.success', $reservation->id) }}";
        }
    } catch (error) {
        alert(error.message || "Payment failed.");
    } finally {
        payBtn.disabled = false;
        payBtn.classList.remove("opacity-60", "cursor-not-allowed");
    }
});
</script>

@endsection