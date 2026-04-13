@extends('layouts.public')

@section('title', 'Fields Management')

@section('content')
<div class="min-h-screen bg-gray-50 pb-20">

    <!-- Gallery Header -->
    <section class="h-[70vh] w-full">
            <img
                src="{{ Storage::disk('r2')->url($field->image_path)}}" 
                alt="{{ $field->name ?? 'Field image' }}"
                class="h-full w-full rounded3xl object-cover"
            >
    </section>

    <div class="container mx-auto mt-8 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 lg:gap-12">

            <!-- Main Content -->
            <div class="space-y-10 lg:col-span-2">

                <!-- Header -->
                <section>
                    <div class="mb-4 flex flex-wrap items-center gap-3">

                        <span class="inline-flex items-center gap-1 rounded-lg bg-green-100 px-3 py-1 text-sm font-bold text-green-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            {{ $field->type ?? 'Field Type' }}
                        </span>

                        <span class="inline-flex items-center gap-1 rounded-lg bg-yellow-50 px-3 py-1 text-sm font-bold text-yellow-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-yellow-500 text-yellow-500" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 00.951-.69l1.068-3.292z"/>
                            </svg>
                            {{ $field->rating ?? '0.0' }} ({{ $field->reviews_count ?? 0 }} reviews)
                        </span>

                        @if(!empty($field->is_verified))
                            <span class="inline-flex items-center gap-1 rounded-lg bg-blue-50 px-3 py-1 text-sm font-bold text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 4v5c0 5-3.5 9.74-7 11-3.5-1.26-7-6-7-11V7l7-4z"/>
                                </svg>
                                Verified
                            </span>
                        @endif

                    </div>

                    <h1 class="mb-4 text-4xl font-extrabold tracking-tight text-gray-900">
                        {{ $field->name ?? 'Field Name' }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-2 text-lg text-gray-500">
                        <span class="inline-flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $field->address ?? 'Field Address' }}
                        </span>

                        <a href="#map" class="ml-2 font-semibold text-green-600 underline underline-offset-4">
                            Show on map
                        </a>
                    </div>
                </section>

                <!-- Description -->
                <section class="border-t border-gray-200 pt-8">
                    <h2 class="mb-4 text-2xl font-bold text-gray-900">About this field</h2>
                    <p class="text-lg leading-relaxed text-gray-600">
                        {{ $field->description ?? 'The field description will appear here.' }}
                    </p>
                </section>

                <!-- Amenities -->
                <section class="border-t border-gray-200 pt-8">
                    <h2 class="mb-6 text-2xl font-bold text-gray-900">What this place offers</h2>

                    <div class="grid grid-cols-1 gap-x-8 gap-y-4 text-gray-700 sm:grid-cols-2">
                        @forelse($field->amenities ?? [] as $amenity)
                            <div class="flex items-center gap-3 font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>{{ $amenity }}</span>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-gray-200 bg-white p-4 text-sm text-gray-400 sm:col-span-2">
                                No amenities have been added yet.
                            </div>
                        @endforelse
                    </div>
                </section>

                <!-- Location -->
                <section id="map" class="border-t border-gray-200 pt-8">
                    <h2 class="mb-6 text-2xl font-bold text-gray-900">Location</h2>

                    <div class="relative flex h-80 w-full items-center justify-center overflow-hidden rounded-3xl bg-gray-200 shadow-inner">
                        @if(!empty($field->map_embed_url))
                            <iframe
                                src="{{ $field->map_embed_url }}"
                                class="h-full w-full border-0"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                allowfullscreen
                            ></iframe>
                        @else
                            <div class="absolute inset-0 flex flex-col items-center justify-center bg-gray-100/70 backdrop-blur-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mb-4 h-16 w-16 text-gray-400 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 01.553-.894L9 2l6 3 5.447-2.724A1 1 0 0121 3.618v10.764a1 1 0 01-.553.894L15 18l-6 2z"/>
                                </svg>

                                @if(!empty($field->google_maps_url))
                                    <a
                                        href="{{ $field->google_maps_url }}"
                                        target="_blank"
                                        class="rounded-xl border border-gray-200 bg-white px-5 py-3 font-bold text-gray-900 shadow-lg transition hover:bg-gray-50"
                                    >
                                        Open in Google Maps
                                    </a>
                                @else
                                    <span class="rounded-xl border border-gray-200 bg-white px-5 py-3 font-bold text-gray-400 shadow-lg">
                                        Map link not available
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </section>

                <!-- Reviews -->
                <section class="border-t border-gray-200 pt-8">
                    <h2 class="mb-6 flex items-center gap-2 text-2xl font-bold text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-yellow-400 text-yellow-400" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 00.951-.69l1.068-3.292z"/>
                        </svg>
                        {{ $field->rating ?? '0.0' }}
                        <span class="text-lg font-medium text-gray-400">
                            ({{ $field->reviews_count ?? 0 }} reviews)
                        </span>
                    </h2>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        @forelse($field->reviews ?? [] as $review)
                            <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
                                <div class="mb-4 flex items-center gap-4">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-200 font-bold text-gray-500">
                                        {{ strtoupper(substr($review->user_name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900">{{ $review->user_name ?? 'User' }}</h4>
                                        <span class="text-sm text-gray-500">{{ $review->created_at ?? 'Date not available' }}</span>
                                    </div>
                                </div>

                                <p class="text-sm leading-relaxed text-gray-600">
                                    {{ $review->comment ?? 'No comment provided.' }}
                                </p>
                            </div>
                        @empty
                            <div class="rounded-3xl border border-dashed border-gray-200 bg-white p-6 text-gray-400 md:col-span-2">
                                No reviews yet.
                            </div>
                        @endforelse
                    </div>

                    @if(!empty($field->reviews_count) && $field->reviews_count > 0)
                        <button
                            type="button"
                            class="mt-6 h-12 w-full rounded-xl border border-gray-200 px-8 font-bold text-gray-900 transition hover:bg-gray-50 sm:w-auto"
                        >
                            Show all reviews
                        </button>
                    @endif
                </section>
            </div>

            <!-- Booking Card -->
            <aside class="lg:col-span-1">
                <div class="sticky top-28">
                    <div class="overflow-hidden rounded-[2rem] bg-white shadow-2xl">
                        <div class="flex items-end justify-between bg-gray-900 p-6 text-white">
                            <div>
                                <span class="mb-1 block text-sm font-medium text-gray-400">Starting from</span>
                                <span class="text-4xl font-extrabold">{{ $field->price_per_hour ?? '0' }}</span>
                                <span class="font-medium text-gray-400"> MAD / hour</span>
                            </div>

                            <div class="text-right">
                                <span class="inline-flex items-center gap-1 rounded bg-white/20 px-2 py-1 text-xs font-medium text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 fill-white" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 00.951-.69l1.068-3.292z"/>
                                    </svg>
                                    {{ $field->rating ?? '0.0' }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6 sm:p-8">
                            <form action="" method="POST" class="space-y-6">
                                @csrf

                                <!-- Date -->
                                <div>
                                    <label for="booking_date" class="mb-3 flex items-center gap-2 text-sm font-bold text-gray-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Select date
                                    </label>

                                    <input
                                        id="booking_date"
                                        name="booking_date"
                                        type="date"
                                        value="{{ old('booking_date') }}"
                                        class="h-14 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 font-medium text-gray-900 outline-none transition focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-500/20"
                                    >
                                </div>

                                <!-- Time Slots -->
                                <div>
                                    <label class="mb-3 flex items-center gap-2 text-sm font-bold text-gray-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Select time
                                    </label>

                                    <div class="grid grid-cols-3 gap-3">
                                        @forelse($availableSlots ?? [] as $slot)
                                            <label class="cursor-pointer">
                                                <input
                                                    type="radio"
                                                    name="booking_time"
                                                    value="{{ $slot['time'] }}"
                                                    class="peer sr-only"
                                                    {{ empty($slot['available']) ? 'disabled' : '' }}
                                                >

                                                <span class="
                                                    flex items-center justify-center rounded-xl border py-3 text-sm font-bold transition-all
                                                    {{ empty($slot['available']) 
                                                        ? 'cursor-not-allowed border-gray-100 bg-gray-50 text-gray-300' 
                                                        : 'border-gray-200 bg-white text-gray-700 hover:border-green-500 hover:text-green-600 peer-checked:scale-105 peer-checked:border-green-600 peer-checked:bg-green-600 peer-checked:text-white peer-checked:shadow-md' }}
                                                ">
                                                    {{ $slot['time'] }}
                                                </span>
                                            </label>
                                        @empty
                                            <div class="col-span-3 rounded-2xl border border-dashed border-gray-200 bg-gray-50 p-4 text-sm text-gray-400">
                                                No time slots available for this day.
                                            </div>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Deposit Info -->
                                <div class="flex items-start gap-3 rounded-2xl border border-green-100 bg-green-50 p-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 flex-shrink-0 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"/>
                                    </svg>

                                    <div>
                                        <h4 class="text-sm font-bold text-green-800">Pay the deposit now</h4>
                                        <p class="mt-1 text-xs font-medium leading-relaxed text-green-600">
                                            {{ $field->deposit_text ?? 'You can confirm your booking by paying the deposit first, then pay the remaining amount at the venue.' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Submit -->
                                <button
                                    type="submit"
                                    class="h-14 w-full rounded-2xl bg-gray-900 text-lg font-bold text-white shadow-xl transition hover:bg-gray-800 hover:shadow-2xl"
                                >
                                    Continue booking
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-center gap-2 text-sm font-medium text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 4v5c0 5-3.5 9.74-7 11-3.5-1.26-7-6-7-11V7l7-4z"/>
                        </svg>
                        Secure and encrypted checkout
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection