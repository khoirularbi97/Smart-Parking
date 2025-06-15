@extends('layouts.user')

@section('content')
<div class=" bg-gradient-to-b from-blue-100 to-white flex items-center justify-center py-10">
    <div class="bg-white w-[360px] rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 text-white text-center py-4 relative">
            <a href="{{ route('topup.form') }}" class="absolute left-4 top-4 text-white text-xl">&#8592;</a>
            <p class="text-sm font-medium">#{{ $invoice->order_id }}</p>

            <div class="mt-2">
                <div class="w-20 h-20 mx-auto bg-white rounded-full flex items-center justify-center shadow-md">
                    {{-- <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 17v-6h13M9 11V5h13M5 21h14a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2z"/>
                        
                    </svg> --}}
                    <i data-lucide="circle-check-big" class="w-10 h-10 text-blue-600 "></i>
                </div>
                <p class="text-xs mt-2 font-bold font-light tracking-wide uppercase">SUCCESS</p>
            </div>
        </div>

        <!-- Invoice Card -->
        <div class="bg-white rounded-t-xl -mt-5 px-6 pt-6 pb-8 text-gray-700 text-sm">
            <div class="flex justify-between mb-4">
                <div>
                    <p class="text-xs text-gray-400 font-medium">ORDER #</p>
                    <p class="font-semibold">{{ $invoice->order_id }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400 font-medium">DUE ON</p>
                    <p class="font-semibold">{{ \Carbon\Carbon::parse($invoice->created_at)->format('M d, Y') }}</p>
                </div>
            </div>

            <div class="flex justify-between items-center bg-gray-100 rounded-lg py-3 px-4 mb-4">
                <div>
                    <p class="text-xs text-gray-500">TOPUP</p>
                    <p class="text-xl font-bold">{{ $invoice->name }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500">METODE</p>
                    <p class="text-xl font-bold">{{ strtoupper($invoice->method) }}</p>
                </div>
            </div>

            <div class="border-t pt-4 text-center">
                <p class="text-xs text-gray-400 uppercase">Total Amount</p>
                <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</p>
            </div>

            <div class="mt-6">
                <a href="{{ route('user.dashboard') }}" class="block bg-green-500 hover:bg-green-600 text-white text-center py-3 rounded-lg text-sm font-semibold shadow-md">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
