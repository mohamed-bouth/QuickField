@extends('layouts.public')

@section('title', 'Fields Management')

@section('content')

<div class="min-h-screen bg-gray-50 py-8 lg:py-12">
    <div class="container mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <a href="{{ route('public.fields.show', $field->id) }}"
           class="group mb-8 inline-flex items-center font-medium text-gray-500 transition-colors hover:text-gray-900">
            <svg class="mr-1 h-5 w-5 transition-transform group-hover:-translate-x-1"
                 xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Field Details
        </a>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 lg:gap-12">
            <div class="space-y-8 lg:col-span-2">
                <div>
                    <h1 class="mb-2 text-3xl font-extrabold tracking-tight text-gray-900">Confirm & Pay</h1>
                    <p class="text-lg text-gray-500">Secure your booking by paying the 50% deposit.</p>
                </div>

                <form action="" method="POST" class="space-y-8">
                    @csrf
                    <input type="hidden" name="field_id" value="{{ $field->id }}">

                    <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
                        <h2 class="mb-6 flex items-center gap-2 text-xl font-bold text-gray-900">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 text-sm text-green-700">1</span>
                            Your Details
                        </h2>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700">First Name</label>
                                <input
                                    type="text"
                                    name="first_name"
                                    placeholder="ex:mohamed"
                                    value="{{ old('first_name') }}"
                                    class="h-14 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 text-base outline-none transition focus:bg-white focus:ring-2 focus:ring-green-500"
                                >
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700">Last Name</label>
                                <input
                                    type="text"
                                    name="last_name"
                                    placeholder="ex:rashidi"
                                    value="{{ old('last_name') }}"
                                    class="h-14 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 text-base outline-none transition focus:bg-white focus:ring-2 focus:ring-green-500"
                                >
                            </div>

                            <div class="space-y-2 md:col-span-2">
                                <label class="text-sm font-bold text-gray-700">Email Address</label>
                                <input
                                    type="email"
                                    name="email"
                                    placeholder="john@example.com"
                                    value="{{ $user->email ?? old('email') }}"
                                    class="h-14 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 text-base outline-none transition focus:bg-white focus:ring-2 focus:ring-green-500"
                                >
                            </div>

                            <div class="space-y-2 md:col-span-2">
                                <label class="text-sm font-bold text-gray-700">Phone Number (for SMS updates)</label>
                                <input
                                    type="tel"
                                    name="phone"
                                    required
                                    placeholder="+212 6 00 00 00 00"
                                    value="{{ $user->phone ?? old('phone') }}"
                                    class="h-14 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 text-base outline-none transition focus:bg-white focus:ring-2 focus:ring-green-500"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
                        <h2 class="mb-6 flex items-center gap-2 text-xl font-bold text-gray-900">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 text-sm text-green-700">2</span>
                            Payment Method
                        </h2>

                        <div class="mb-6 flex items-center justify-between rounded-2xl border border-gray-200 bg-gray-50 p-4">
                            <div class="flex items-center gap-3">
                                <svg class="h-6 w-6 text-gray-400"
                                     xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.25 8.25h19.5m-18 0A1.5 1.5 0 0 0 2.25 9.75v7.5a1.5 1.5 0 0 0 1.5 1.5h16.5a1.5 1.5 0 0 0 1.5-1.5v-7.5a1.5 1.5 0 0 0-1.5-1.5m-18 0V6.75a1.5 1.5 0 0 1 1.5-1.5h16.5a1.5 1.5 0 0 1 1.5 1.5v1.5" />
                                </svg>
                                <span class="font-bold text-gray-900">Credit / Debit Card</span>
                            </div>

                            <div class="flex gap-2">
                                <div class="flex h-6 w-10 items-center justify-center rounded border border-gray-200 bg-white text-[10px] font-bold text-blue-900">
                                    VISA
                                </div>
                                <div class="flex h-6 w-10 items-center justify-center rounded border border-gray-200 bg-white text-[10px] font-bold text-red-600">
                                    MC
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700">Card Number</label>
                                <input
                                    type="text"
                                    name="card_number"
                                    required
                                    placeholder="0000 0000 0000 0000"
                                    class="h-14 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 font-mono text-base outline-none transition focus:bg-white focus:ring-2 focus:ring-green-500"
                                >
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-gray-700">Expiry Date</label>
                                    <input
                                        type="text"
                                        name="expiry_date"
                                        required
                                        placeholder="MM/YY"
                                        class="h-14 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 font-mono text-base outline-none transition focus:bg-white focus:ring-2 focus:ring-green-500"
                                    >
                                </div>

                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-gray-700">CVC</label>
                                    <input
                                        type="text"
                                        name="cvc"
                                        required
                                        placeholder="123"
                                        class="h-14 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 font-mono text-base outline-none transition focus:bg-white focus:ring-2 focus:ring-green-500"
                                    >
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700">Name on Card</label>
                                <input
                                    type="text"
                                    name="card_name"
                                    required
                                    placeholder="JOHN DOE"
                                    class="h-14 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 text-base outline-none transition focus:bg-white focus:ring-2 focus:ring-green-500"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button
                            type="submit"
                            class="h-16 w-full rounded-2xl bg-gray-900 text-xl font-extrabold text-white shadow-xl transition-all hover:bg-gray-800 hover:shadow-2xl">
                            Pay ${{ number_format($field->prices[0]->price/2, 2) }} & Confirm Booking
                        </button>

                        <p class="mt-4 flex items-center justify-center gap-1 text-center text-sm font-medium text-gray-500">
                            <svg class="h-4 w-4 text-green-500"
                                 xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9 12.75 11.25 15 15 9.75m6 2.25a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            Payments are secure and encrypted
                        </p>
                    </div>
                </form>
            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-28 overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-xl">
                    <div class="relative h-48">
                        <img
                            src="{{ Storage::disk('r2')->url($field->image_path)}}" 
                            alt="{{ $field->name }}"
                            class="h-full w-full object-cover"
                        >

                        <div class="absolute inset-0 flex items-end bg-gradient-to-t from-gray-900/80 to-transparent p-6">
                            <h3 class="text-2xl font-extrabold tracking-tight text-white">{{ $field->name }}</h3>
                        </div>
                    </div>

                    <div class="p-6 sm:p-8">
                        <div class="mb-8 space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gray-50 text-gray-500">
                                    <svg class="h-5 w-5"
                                         xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M6.75 3v2.25M17.25 3v2.25M3 18.75V8.25A2.25 2.25 0 0 1 5.25 6h13.5A2.25 2.25 0 0 1 21 8.25v10.5A2.25 2.25 0 0 1 18.75 21H5.25A2.25 2.25 0 0 1 3 18.75ZM3 10.5h18" />
                                    </svg>
                                </div>
                                <div>
                                    @php
                                        $dateTime = \Carbon\Carbon::parse($reservation->start_time);
                                        $endDateTime = \Carbon\Carbon::parse($reservation->end_time);
                                    @endphp
                                    <div class="text-sm font-bold text-gray-900">Date</div>
                                    <div class="font-medium text-gray-500">{{ $dateTime->format('Y-m-d') }}</div>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gray-50 text-gray-500">
                                    <svg class="h-5 w-5"
                                         xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M12 6v6l4 2m5-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </div>
                                <div>
                                    
                                    <div class="text-sm font-bold text-gray-900">Time</div>
                                    <div class="font-medium text-gray-500">{{ $dateTime->format('H:i')}} / {{ $endDateTime->format('H:i') }}</div>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gray-50 text-gray-500">
                                    <svg class="h-5 w-5"
                                         xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M19.5 10.5c0 7.142-7.5 10.5-7.5 10.5S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900">Location</div>
                                    <div class="font-medium text-gray-500">{{ $field->localisation }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4 border-t border-gray-100 pt-6">
                            <h4 class="font-bold text-gray-900">Price Details</h4>

                            <div class="flex justify-between font-medium text-gray-600">
                                <span>Total Field Price</span>
                                <span>${{ number_format($field->prices[0]->price, 2) }}</span>
                            </div>

                            <div class="my-4 rounded-xl bg-green-50 p-4">
                                <div class="mb-1 flex justify-between font-bold text-green-800">
                                    <span>Deposit to pay now (50%)</span>
                                    <span class="text-xl">${{ number_format($field->prices[0]->price/2, 2) }}</span>
                                </div>
                                <p class="text-xs font-medium text-green-600">
                                    This secures your slot immediately.
                                </p>
                            </div>

                            <div class="flex justify-between border-t border-gray-100 pt-2 text-sm font-medium text-gray-500">
                                <span>Remaining amount</span>
                                <span>${{ number_format($field->prices[0]->price/2, 2) }}</span>
                            </div>

                            <p class="text-xs text-gray-400">
                                To be paid directly at the field reception upon arrival.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection