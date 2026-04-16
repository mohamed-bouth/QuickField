@extends('layouts.admin')

@section('title', 'Fields Management')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Field Details</h1>
            <p class="text-gray-500">Manage Your fields, Open/Close time, Days prices and availability.</p>
        </div>

        <a href="{{ route('admin.fields.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white rounded-xl shadow-sm px-6 h-12 inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
            </svg>
            <span>Add Field</span>
        </a>
    </div>
    <div class="mb-6 rounded-2xl bg-white p-6 shadow">
        <img
            src="{{ Storage::disk('r2')->url($field->image_path) }}"
            class="mb-4 h-64 w-full rounded-xl object-cover">

        <h1 class="text-2xl font-bold">{{ $field->name }}</h1>
        <p class="text-gray-600">{{ $field->description }}</p>

        <div class="mt-4 grid gap-3 md:grid-cols-3">
            <div>Localisation: {{ $field->localisation }}</div>
            <div>Type: {{ $field->type }}</div>
            <div>Status: {{ $field->status }}</div>
        </div>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow">
        <h2 class="mb-4 text-xl font-bold">Planning de la semaine</h2>
            @if ($errors->any())
                <div class="mb-4 rounded bg-red-50 p-3 text-red-700">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <form method="POST" action="{{ route('admin.fields.planning.update' , $field->id) }}">
            @csrf
            @method('PUT')

            <table class="w-full text-left">
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Open Time</th>
                        <th>Close Time</th>
                        <th>Price</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($field->fieldWorkHours as $workHour)
                    @php
                    $price = $field->prices->firstWhere('day_of_week', $workHour->day_of_week);
                    @endphp

                    <tr>
                        <td>
                            {{ $workHour->day_of_week }}

                            <input type="hidden"
                                name="work_hours[{{ $workHour->id }}][id]"
                                value="{{ $workHour->id }}">

                            <input type="hidden"
                                name="prices[{{ $price->id }}][id]"
                                value="{{ $price->id }}">
                        </td>

                        <td>
                            <input type="time"
                            name="work_hours[{{ $workHour->id }}][open_time]"
                            value="{{ \Carbon\Carbon::parse($workHour->open_time)->format('H:i') }}">
                        </td>

                        <td>
                            <input type="time"
                            name="work_hours[{{ $workHour->id }}][close_time]"
                            value="{{ \Carbon\Carbon::parse($workHour->close_time)->format('H:i') }}">
                        </td>

                        <td>
                            <input type="number"
                                name="prices[{{ $price->id }}][price]"
                                value="{{ $price->price }}">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="mt-4 rounded bg-green-600 px-4 py-2 text-white">
                Save changes
            </button>
        </form>
    </div>
</div>
@endsection