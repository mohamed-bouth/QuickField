@extends('layouts.guest') @section('content')
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-12 px-8 py-20 max-w-7xl mx-auto">
        <div class="flex flex-col justify-center space-y-8">
            <h1 class="text-5xl font-bold leading-tight text-gray-900">
                Book Your Perfect <br> Football Field
            </h1>
            <p class="text-lg text-gray-500 max-w-md">
                Find and reserve premium football fields near you in seconds. Perfect pitches for your perfect game.
            </p>
            
            <div class="flex items-center gap-4">
                <a href="/login" class="px-6 py-3 text-white bg-green-500 rounded-full font-medium hover:bg-green-600 transition">Get Started</a>
                <a href="/login" class="px-6 py-3 text-green-500 border border-green-500 rounded-full font-medium hover:bg-green-50 transition">Browse Fields</a>
            </div>

            <div class="flex items-center gap-12 pt-8">
                <div>
                    <h3 class="text-3xl font-bold text-green-500">50+</h3>
                    <p class="text-sm text-gray-500">Fields</p>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-green-500">10k+</h3>
                    <p class="text-sm text-gray-500">Bookings</p>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-green-500">98%</h3>
                    <p class="text-sm text-gray-500">Satisfaction</p>
                </div>
            </div>
        </div>

        <div class="relative">
            <img src="https://pub-bd8291a7790f4b588b9daf7b1db26e25.r2.dev/app-image/welcome-field-image.jpg" alt="Football Field" class="rounded-3xl shadow-2xl object-cover h-[500px] w-full">
            
            <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-2xl shadow-xl flex items-center gap-4">
                <div class="bg-green-100 p-2 rounded-full text-green-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 text-sm">Instant Confirmation</h4>
                    <p class="text-xs text-gray-500">Book now, play today</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 max-w-7xl mx-auto px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose QuickField?</h2>
            <p class="text-gray-500">We make booking football fields simple, fast, and reliable</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="bg-green-50 w-12 h-12 flex items-center justify-center rounded-full text-green-500 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Easy Booking</h3>
                <p class="text-gray-500">Book your field in just a few clicks</p>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="bg-green-50 w-12 h-12 flex items-center justify-center rounded-full text-green-500 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Real-time Availability</h3>
                <p class="text-gray-500">See available time slots instantly</p>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="bg-green-50 w-12 h-12 flex items-center justify-center rounded-full text-green-500 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Multiple Locations</h3>
                <p class="text-gray-500">Choose from various premium fields</p>
            </div>
        </div>
    </section>

    <section class="bg-green-600 py-20 mt-12">
        <div class="max-w-4xl mx-auto text-center px-8">
            <h2 class="text-3xl font-bold text-white mb-4">Ready to Play?</h2>
            <p class="text-green-100 mb-8 text-lg">Join thousands of players who trust QuickField for their bookings</p>
            <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-white text-green-600 rounded-full font-bold hover:bg-gray-100 transition shadow-lg">Create Free Account</a>
        </div>
    </section>
@endsection