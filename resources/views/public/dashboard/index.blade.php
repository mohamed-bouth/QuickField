@extends('layouts.public')

@section('title', 'Fields Management')

@section('content')
<!-- Hero Section -->
  <section class="bg-[#eef5ef]">
    <div class="max-w-7xl mx-auto py-40">
      <div class="max-w-4xl mx-auto text-center">

        <div class="inline-flex items-center gap-2 rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 3L4 14h7l-1 7 9-11h-7l1-7z"/>
          </svg>
          <span>FAST & EASY BOOKING</span>
        </div>

        <h1 class="mt-8 text-5xl md:text-6xl lg:text-7xl font-bold tracking-tight leading-tight text-slate-950">
          Book Your Perfect
          <span class="block text-green-600">Football Pitch</span>
        </h1>

        <p class="mt-6 text-lg md:text-xl leading-8 text-slate-600 max-w-3xl mx-auto">
          Find, compare, and reserve premium football fields near you in seconds.
          Get your squad together, we'll handle the rest.
        </p>

        <!-- Search Box -->
        <div class="mt-12 max-w-4xl mx-auto rounded-[28px] bg-white shadow-[0_10px_30px_rgba(15,23,42,0.08)] border border-slate-100 p-4">
          <div class="grid grid-cols-1 md:grid-cols-[1.3fr_0.7fr_auto] gap-3">
            
            <div class="h-16 rounded-2xl bg-slate-50 px-5 flex items-center gap-3 text-slate-500">
              <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-7-4.35-7-10a7 7 0 1114 0c0 5.65-7 10-7 10z"/>
                <circle cx="12" cy="11" r="2.5"/>
              </svg>
              <input
                type="text"
                placeholder="Where do you want to play?"
                class="w-full bg-transparent outline-none placeholder:text-slate-400 text-slate-700"
              />
            </div>

            <div class="h-16 rounded-2xl bg-slate-50 px-5 flex items-center gap-3 text-slate-500">
              <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z"/>
              </svg>
              <input
                type="date"
                class="w-full bg-transparent outline-none text-slate-700"
              />
            </div>

            <button class="h-16 px-8 rounded-2xl bg-green-600 hover:bg-green-700 text-white text-lg font-semibold shadow-sm transition">
              Search Fields
            </button>
          </div>
        </div>

        <!-- Features -->
        <div class="mt-10 flex flex-wrap items-center justify-center gap-x-10 gap-y-4 text-slate-500">
          <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-sm md:text-base">Instant Confirmation</span>
          </div>

          <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 4v5c0 5-3.5 8-7 9-3.5-1-7-4-7-9V7l7-4z"/>
            </svg>
            <span class="text-sm md:text-base">Secure Payments</span>
          </div>

          <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13 3L4 14h7l-1 7 9-11h-7l1-7z"/>
            </svg>
            <span class="text-sm md:text-base">Digital Tickets</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Featured Fields -->
  <section class="bg-[#f8f8f8] py-40">
    <div class="w-100% px-20 lg:px-8">
      
      <div class="flex items-end justify-between gap-4 mb-10">
        <div>
          <h2 class="text-4xl font-bold tracking-tight text-slate-950">Featured Fields</h2>
          <p class="mt-3 text-lg text-slate-500">
            Top-rated pitches ready for your next match.
          </p>
        </div>

        <a href="#" class="hidden md:inline-flex items-center gap-2 text-green-600 font-semibold hover:text-green-700 transition">
          <span>View All</span>
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/>
          </svg>
        </a>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

        <!-- Card 1 -->
        <article class="overflow-hidden rounded-[28px] bg-white border border-slate-200 shadow-[0_6px_20px_rgba(15,23,42,0.06)]">
          <div class="relative">
            <img
              src="https://images.unsplash.com/photo-1547347298-4074fc3086f0?auto=format&fit=crop&w=1200&q=80"
              alt="Grand Arena 7v7"
              class="h-72 w-full object-cover"
            />

            <span class="absolute top-4 left-4 rounded-full bg-white/95 px-4 py-1.5 text-sm font-normal text-slate-700 shadow-sm">
              7v7
            </span>

            <button class="absolute top-4 right-4 w-12 h-12 rounded-full bg-white/95 shadow-sm flex items-center justify-center text-slate-400 hover:text-red-500 transition">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12.1 20.3l-.1.1-.1-.1C7 15.9 4 13.1 4 9.5A4.5 4.5 0 018.5 5c1.7 0 2.9.8 3.5 1.9A4.1 4.1 0 0115.5 5 4.5 4.5 0 0120 9.5c0 3.6-3 6.4-7.9 10.8z"/>
              </svg>
            </button>
          </div>

          <div class="p-6">
            <div class="flex items-start justify-between gap-4">
              <div>
                <h3 class="text-3xl font-semibold text-slate-950">Grand Arena 7v7</h3>
                <div class="mt-3 flex items-center gap-2 text-slate-500">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-7-4.35-7-10a7 7 0 1114 0c0 5.65-7 10-7 10z"/>
                    <circle cx="12" cy="11" r="2.5"/>
                  </svg>
                  <span>Downtown Complex</span>
                </div>
              </div>

              <div class="inline-flex items-center gap-1 rounded-full bg-green-50 px-3 py-1.5 text-green-700 font-semibold">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                  <path d="M10 1.5l2.6 5.27 5.82.85-4.21 4.1.99 5.79L10 14.77 4.8 17.5l.99-5.79-4.21-4.1 5.82-.85L10 1.5z"/>
                </svg>
                <span>4.8</span>
              </div>
            </div>

            <div class="mt-6 border-t border-slate-200 pt-5 flex items-center justify-between">
              <div>
                <span class="text-4xl font-bold text-slate-950">$80</span>
                <span class="text-slate-500 text-lg"> /hour</span>
              </div>

              <a href="#" class="inline-flex items-center justify-center rounded-2xl bg-green-600 px-7 h-12 text-white font-semibold hover:bg-green-700 transition">
                Book Now
              </a>
            </div>
          </div>
        </article>

        <!-- Card 2 -->
        <article class="overflow-hidden rounded-[28px] bg-white border border-slate-200 shadow-[0_6px_20px_rgba(15,23,42,0.06)]">
          <div class="relative">
            <img
              src="https://images.unsplash.com/photo-1517466787929-bc90951d0974?auto=format&fit=crop&w=1200&q=80"
              alt="Green Pitch Night"
              class="h-72 w-full object-cover"
            />

            <span class="absolute top-4 left-4 rounded-full bg-white/95 px-4 py-1.5 text-sm font-semibold text-slate-700 shadow-sm">
              5v5
            </span>

            <button class="absolute top-4 right-4 w-12 h-12 rounded-full bg-white/95 shadow-sm flex items-center justify-center text-slate-400 hover:text-red-500 transition">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12.1 20.3l-.1.1-.1-.1C7 15.9 4 13.1 4 9.5A4.5 4.5 0 018.5 5c1.7 0 2.9.8 3.5 1.9A4.1 4.1 0 0115.5 5 4.5 4.5 0 0120 9.5c0 3.6-3 6.4-7.9 10.8z"/>
              </svg>
            </button>
          </div>

          <div class="p-6">
            <div class="flex items-start justify-between gap-4">
              <div>
                <h3 class="text-3xl font-semibold text-slate-950">Green Pitch Night</h3>
                <div class="mt-3 flex items-center gap-2 text-slate-500">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-7-4.35-7-10a7 7 0 1114 0c0 5.65-7 10-7 10z"/>
                    <circle cx="12" cy="11" r="2.5"/>
                  </svg>
                  <span>North Side Arena</span>
                </div>
              </div>

              <div class="inline-flex items-center gap-1 rounded-full bg-green-50 px-3 py-1.5 text-green-700 font-semibold">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                  <path d="M10 1.5l2.6 5.27 5.82.85-4.21 4.1.99 5.79L10 14.77 4.8 17.5l.99-5.79-4.21-4.1 5.82-.85L10 1.5z"/>
                </svg>
                <span>4.9</span>
              </div>
            </div>

            <div class="mt-6 border-t border-slate-200 pt-5 flex items-center justify-between">
              <div>
                <span class="text-4xl font-bold text-slate-950">$65</span>
                <span class="text-slate-500 text-lg"> /hour</span>
              </div>

              <a href="#" class="inline-flex items-center justify-center rounded-2xl bg-green-600 px-7 h-12 text-white font-semibold hover:bg-green-700 transition">
                Book Now
              </a>
            </div>
          </div>
        </article>

        <!-- Card 3 -->
        <article class="overflow-hidden rounded-[28px] bg-white border border-slate-200 shadow-[0_6px_20px_rgba(15,23,42,0.06)]">
          <div class="relative">
            <img
              src="https://images.unsplash.com/photo-1518604666860-9ed391f76460?auto=format&fit=crop&w=1200&q=80"
              alt="Pro Turf Stadium"
              class="h-72 w-full object-cover"
            />

            <span class="absolute top-4 left-4 rounded-full bg-white/95 px-4 py-1.5 text-sm font-semibold text-slate-700 shadow-sm">
              7v7
            </span>

            <button class="absolute top-4 right-4 w-12 h-12 rounded-full bg-white/95 shadow-sm flex items-center justify-center text-slate-400 hover:text-red-500 transition">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12.1 20.3l-.1.1-.1-.1C7 15.9 4 13.1 4 9.5A4.5 4.5 0 018.5 5c1.7 0 2.9.8 3.5 1.9A4.1 4.1 0 0115.5 5 4.5 4.5 0 0120 9.5c0 3.6-3 6.4-7.9 10.8z"/>
              </svg>
            </button>
          </div>

          <div class="p-6">
            <div class="flex items-start justify-between gap-4">
              <div>
                <h3 class="text-3xl font-semibold text-slate-950">Pro Turf Stadium</h3>
                <div class="mt-3 flex items-center gap-2 text-slate-500">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-7-4.35-7-10a7 7 0 1114 0c0 5.65-7 10-7 10z"/>
                    <circle cx="12" cy="11" r="2.5"/>
                  </svg>
                  <span>West End Center</span>
                </div>
              </div>

              <div class="inline-flex items-center gap-1 rounded-full bg-green-50 px-3 py-1.5 text-green-700 font-semibold">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                  <path d="M10 1.5l2.6 5.27 5.82.85-4.21 4.1.99 5.79L10 14.77 4.8 17.5l.99-5.79-4.21-4.1 5.82-.85L10 1.5z"/>
                </svg>
                <span>4.7</span>
              </div>
            </div>

            <div class="mt-6 border-t border-slate-200 pt-5 flex items-center justify-between">
              <div>
                <span class="text-4xl font-bold text-slate-950">$90</span>
                <span class="text-slate-500 text-lg"> /hour</span>
              </div>

              <a href="#" class="inline-flex items-center justify-center rounded-2xl bg-green-600 px-7 h-12 text-white font-semibold hover:bg-green-700 transition">
                Book Now
              </a>
            </div>
          </div>
        </article>

      </div>

      <div class="mt-8 md:hidden">
        <a href="#" class="inline-flex items-center gap-2 text-green-600 font-semibold hover:text-green-700 transition">
          <span>View All</span>
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/>
          </svg>
        </a>
      </div>
    </div>
  </section>
@endsection