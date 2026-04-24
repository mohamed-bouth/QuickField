@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-emerald-100 bg-gradient-to-r from-emerald-50 to-white p-6">
            @if($dashboardRole === 'super_admin')
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Super Admin Dashboard</h1>
                <p class="mt-1 text-gray-600">Statistics for {{ $monthLabel ?? '' }} compared to {{ $previousMonthLabel ?? '' }}.</p>
            @elseif($dashboardRole === 'field_manager')
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Field Manager Dashboard</h1>
                <p class="mt-1 text-gray-600">Statistics for {{ $monthLabel ?? '' }} compared to {{ $previousMonthLabel ?? '' }}.</p>
            @elseif($dashboardRole === 'field_guard')
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Guard Dashboard</h1>
                <p class="mt-1 text-gray-600">Overview for today's assignments.</p>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
            @foreach($stats as $stat)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <p class="text-sm font-medium text-gray-500">{{ $stat['label'] }}</p>
                    <div class="mt-2 flex items-end justify-between gap-3">
                        <p class="text-3xl font-bold text-gray-900">{{ $stat['value'] }}{{ $stat['suffix'] }}</p>
                        
                        {{-- Only show growth pill if the array key exists (Super Admin) --}}
                        @if(isset($stat['growth']))
                            @php
                                $isPositive = $stat['growth'] >= 0;
                                $growthClass = $isPositive ? 'text-green-700 bg-green-50 border-green-200' : 'text-red-700 bg-red-50 border-red-200';
                                $growthPrefix = $isPositive ? '+' : '';
                            @endphp
                            <span class="inline-flex items-center rounded-full border px-2.5 py-1 text-xs font-semibold {{ $growthClass }}">
                                {{ $growthPrefix }}{{ number_format($stat['growth'], 2) }}%
                            </span>
                        @endif
                    </div>
                    @if(isset($stat['growth']))
                        <p class="mt-3 text-xs text-gray-400">Month over month growth</p>
                    @endif
                </div>
            @endforeach
        </div>

        @if(in_array($dashboardRole, ['super_admin', 'field_manager']))
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-900">Top Reserved Fields {{ $dashboardRole === 'super_admin' ? '(Completed)' : '' }}</h2>
                    @if(isset($topReservedFields) && $topReservedFields->isNotEmpty())
                        <div class="mt-4 space-y-3">
                            @foreach($topReservedFields as $index => $field)
                                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-start gap-3">
                                            <div class="h-14 w-14 overflow-hidden rounded-lg border border-gray-200 bg-white">
                                                @if($field->image_path)
                                                    <img
                                                        src="{{ Storage::disk('r2')->url($field->image_path) }}"
                                                        alt="{{ $field->name }}"
                                                        class="h-full w-full object-cover"
                                                    >
                                                @endif
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-emerald-700">#{{ $index + 1 }}</p>
                                                <p class="text-base font-semibold text-gray-900">{{ $field->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $field->localisation }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            {{-- Super Admin passes 'completed_reservations_count', Manager passes 'reservations_count' --}}
                                            <p class="text-sm font-semibold text-gray-900">{{ $field->completed_reservations_count ?? $field->reservations_count }}</p>
                                            <p class="text-xs text-gray-500">reservations</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-4 text-sm text-gray-500">No reservation data available yet.</p>
                    @endif
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-900">Top Rated Fields (Avg Rating)</h2>
                    @if(isset($topRatedFields) && $topRatedFields->isNotEmpty())
                        <div class="mt-4 space-y-3">
                            @foreach($topRatedFields as $index => $field)
                                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-start gap-3">
                                            <div class="h-14 w-14 overflow-hidden rounded-lg border border-gray-200 bg-white">
                                                @if($field->image_path)
                                                    <img
                                                        src="{{ Storage::disk('r2')->url($field->image_path) }}"
                                                        alt="{{ $field->name }}"
                                                        class="h-full w-full object-cover"
                                                    >
                                                @endif
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-blue-700">#{{ $index + 1 }}</p>
                                                <p class="text-base font-semibold text-gray-900">{{ $field->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $field->localisation }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-semibold text-gray-900">{{ number_format((float) $field->reviews_avg_rating, 2) }} / 5</p>
                                            <p class="text-xs text-gray-500">{{ $field->reviews_count }} reviews</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-4 text-sm text-gray-500">No rating data available yet.</p>
                    @endif
                </div>
            </div>
            
        @elseif($dashboardRole === 'field_guard')
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-900">Upcoming Reservations</h2>
                    <p class="text-sm text-gray-500">Next 3 hours (until {{ $nextThreeHoursLabel }})</p>
                    
                    @if(isset($upcomingReservations) && $upcomingReservations->isNotEmpty())
                        <div class="mt-4 space-y-3">
                            @foreach($upcomingReservations as $reservation)
                                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4 flex items-center justify-between">
                                    <div>
                                        <p class="text-base font-semibold text-gray-900">{{ $reservation->user->name ?? 'Guest User' }}</p>
                                        <p class="text-sm text-gray-600">{{ $reservation->field->name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-emerald-700">{{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}</p>
                                        <p class="text-xs text-gray-500 capitalize">{{ $reservation->status }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-4 text-sm text-gray-500">No upcoming reservations for the next 3 hours.</p>
                    @endif
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-900">Assigned Fields Overview</h2>
                    
                    @if(isset($guardFields) && $guardFields->isNotEmpty())
                        <div class="mt-4 space-y-3">
                            @foreach($guardFields as $field)
                                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4 flex items-center justify-between">
                                    <div>
                                        <p class="text-base font-semibold text-gray-900">{{ $field->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $field->localisation }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-gray-700">Manager: {{ $field->user->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-4 text-sm text-gray-500">No fields assigned to you currently.</p>
                    @endif
                </div>
            </div>
        @endif
        
    </div>
@endsection