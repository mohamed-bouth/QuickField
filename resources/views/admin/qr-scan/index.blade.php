@extends('layouts.admin') @section('title', 'Scan Ticket')

@section('content')
<div class="max-w-lg mx-auto mt-10 px-4">
    
    <div class="text-center mb-8">
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
            <i class="fas fa-qrcode text-2xl text-green-600"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900">Scan Ticket</h2>
        <p class="mt-2 text-sm text-gray-500">Enter the ticket hash or reservation number</p>
    </div>

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md shadow-sm mb-6">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                <p class="text-sm text-red-700">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm mb-6">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="bg-white p-6 shadow-sm rounded-xl border border-gray-200">
        <form action="{{ route('admin.scan-ticket.verify') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label for="qr_code_hash" class="block text-sm font-medium text-gray-700 mb-1">
                    Code Hash / Reservation Number
                </label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-barcode text-gray-400"></i>
                    </div>
                    <input type="text" name="qr_code_hash" id="qr_code_hash" required autofocus autocomplete="off"
                        class="focus:ring-green-500 focus:border-green-500 block w-full pl-10 pr-3 py-2.5 sm:text-sm border border-gray-300 rounded-lg bg-gray-50"
                        placeholder="Ex: a1b2c3d4...">
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i> type the hash here
                </p>
            </div>

            <div>
                <button type="submit" 
                    class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                    <i class="fas fa-search mr-2"></i> search for reservation
                </button>
            </div>
        </form>
    </div>
    
</div>
@endsection