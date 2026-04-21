@extends('layouts.public')

@section('title', 'Fields Management')

@section('content')
<div class="min-h-screen bg-gray-50 pb-20">
    @php
        $averageRating = number_format((float) ($field->reviews_avg_rating ?? 0), 1);
        $reviewsCount = $field->reviews_count ?? 0;
    @endphp

    <!-- Gallery Header -->
    <section class="h-[70vh] w-full">
        <img
            src="{{ Storage::disk('r2')->url($field->image_path)}}"
            alt="{{ $field->name ?? 'Field image' }}"
            class="h-full w-full rounded3xl object-cover">
    </section>

    <div class="container mx-auto mt-8 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 lg:gap-12">

            <!-- Main Content -->
            <div class="space-y-10 lg:col-span-1">

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
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 00.951-.69l1.068-3.292z" />
                            </svg>
                            {{ $averageRating }} ({{ $reviewsCount }} reviews)
                        </span>

                        @if(!empty($field->is_verified))
                        <span class="inline-flex items-center gap-1 rounded-lg bg-blue-50 px-3 py-1 text-sm font-bold text-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 4v5c0 5-3.5 9.74-7 11-3.5-1.26-7-6-7-11V7l7-4z" />
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
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
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
                            allowfullscreen></iframe>
                        @else
                        <div class="absolute inset-0 flex flex-col items-center justify-center bg-gray-100/70 backdrop-blur-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mb-4 h-16 w-16 text-gray-400 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 01.553-.894L9 2l6 3 5.447-2.724A1 1 0 0121 3.618v10.764a1 1 0 01-.553.894L15 18l-6 2z" />
                            </svg>

                            @if(!empty($field->google_maps_url))
                            <a
                                href="{{ $field->google_maps_url }}"
                                target="_blank"
                                class="rounded-xl border border-gray-200 bg-white px-5 py-3 font-bold text-gray-900 shadow-lg transition hover:bg-gray-50">
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
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 00.951-.69l1.068-3.292z" />
                        </svg>
                        {{ $averageRating }}
                        <span class="text-lg font-medium text-gray-400">
                            ({{ $reviewsCount }} reviews)
                        </span>
                    </h2>

                    @if(session('review_success'))
                        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-700">
                            {{ session('review_success') }}
                        </div>
                    @endif

                    @if(session('review_error'))
                        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                            {{ session('review_error') }}
                        </div>
                    @endif

                    @if($canReview)
                        <form action="{{ route('public.fields.reviews.store', $field) }}" method="POST" class="mb-6 rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
                            @csrf

                            <h3 class="mb-4 text-lg font-bold text-gray-900">Add your review</h3>

                            <div class="mb-4">
                                <label for="rating" class="mb-2 block text-sm font-bold text-gray-700">Rating</label>
                                <select id="rating" name="rating" class="h-12 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 text-base outline-none transition focus:bg-white focus:ring-2 focus:ring-green-500">
                                    <option value="">Select a rating</option>
                                    @for($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} star{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                                @error('rating')
                                    <p class="mt-1 text-sm font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="comment" class="mb-2 block text-sm font-bold text-gray-700">Comment</label>
                                <textarea id="comment" name="comment" rows="4" class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-base outline-none transition focus:bg-white focus:ring-2 focus:ring-green-500" placeholder="Share your experience...">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <p class="mt-1 text-sm font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="h-12 rounded-xl bg-gray-900 px-6 text-sm font-bold text-white transition hover:bg-gray-800">
                                Submit review
                            </button>
                        </form>
                    @endif

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        @forelse($field->reviews ?? [] as $review)
                        <div class="relative rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
                            @auth
                                @if(auth()->id() === $review->user_id)
                                    <div class="absolute right-4 top-4 z-10 flex items-center gap-2">
                                        <button
                                            type="button"
                                            onclick="document.getElementById('edit-review-form-{{ $review->id }}').classList.toggle('hidden')"
                                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-900 text-white hover:bg-gray-800"
                                            title="Edit review"
                                            aria-label="Edit review"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.1 2.1 0 113 2.97L9.75 16.57l-4.5 1.5 1.5-4.5 10.112-10.083z" />
                                            </svg>
                                        </button>

                                        <form action="{{ route('public.fields.reviews.destroy', [$field, $review]) }}" method="POST" onsubmit="return confirm('Delete this review?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-600 text-white hover:bg-red-700" title="Delete review" aria-label="Delete review">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7V5a1 1 0 011-1h4a1 1 0 011 1v2m-7 0v12a1 1 0 001 1h6a1 1 0 001-1V7" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth

                            <div class="mb-4 flex items-center gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-200 font-bold text-gray-500">
                                    {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ $review->user->name ?? 'User' }}</h4>
                                    <span class="text-sm text-gray-500">{{ $review->created_at ?? 'Date not available' }}</span>
                                </div>
                            </div>

                            <p class="text-sm leading-relaxed text-gray-600">
                                {{ $review->comment ?? 'No comment provided.' }}
                            </p>

                            @auth
                                @if(auth()->id() === $review->user_id)
                                    <div id="edit-review-form-{{ $review->id }}" class="mt-4 hidden border-t border-gray-100 pt-4">
                                        <form action="{{ route('public.fields.reviews.update', [$field, $review]) }}" method="POST" class="space-y-3">
                                            @csrf
                                            @method('PATCH')

                                            <div>
                                                <label class="mb-1 block text-xs font-bold uppercase tracking-wide text-gray-500">Edit rating</label>
                                                <select name="rating" class="h-10 w-full rounded-xl border border-gray-200 bg-gray-50 px-3 text-sm outline-none transition focus:bg-white focus:ring-2 focus:ring-green-500">
                                                    @for($i = 5; $i >= 1; $i--)
                                                        <option value="{{ $i }}" {{ (int) $review->rating === $i ? 'selected' : '' }}>{{ $i }} star{{ $i > 1 ? 's' : '' }}</option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <div>
                                                <label class="mb-1 block text-xs font-bold uppercase tracking-wide text-gray-500">Edit comment</label>
                                                <textarea name="comment" rows="3" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm outline-none transition focus:bg-white focus:ring-2 focus:ring-green-500">{{ $review->comment }}</textarea>
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <button type="submit" class="h-10 rounded-lg bg-gray-900 px-4 text-xs font-semibold text-white hover:bg-gray-800">
                                                    Save changes
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                        @empty
                        <div class="rounded-3xl border border-dashed border-gray-200 bg-white p-6 text-gray-400 md:col-span-2">
                            No reviews yet.
                        </div>
                        @endforelse
                    </div>

                    @if($reviewsCount > 0)
                    <button
                        type="button"
                        class="mt-6 h-12 w-full rounded-xl border border-gray-200 px-8 font-bold text-gray-900 transition hover:bg-gray-50 sm:w-auto">
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
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 00.951-.69l1.068-3.292z" />
                                    </svg>
                                    {{ $averageRating }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6 sm:p-8">
                            <label class="mb-3 flex items-center gap-2 text-sm font-bold text-gray-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Select time
                            </label>

                            <div
                                id="calendar"
                                data-field-id="{{ $field->id }}"
                                class="w-[600px] rounded-2xl bg-white p-4 shadow-sm"></div>

                            @if(session('error'))
                                <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @vite('resources/js/manager-calendar.js')
                        </div>

                    </div>

                    <div class="mt-6 flex items-center justify-center gap-2 text-sm font-medium text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 4v5c0 5-3.5 9.74-7 11-3.5-1.26-7-6-7-11V7l7-4z" />
                        </svg>
                        Secure and encrypted checkout
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection