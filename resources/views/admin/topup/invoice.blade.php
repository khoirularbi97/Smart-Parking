@extends('layouts.app')
@section('title', 'Invoice')


@section('content')
<x-page-header-topup
    title=""
    :breadcrumbs="[
        ['label' => 'Home', 'url' => '/dashboard'],
        ['label' => 'Top-up', 'url' => '/topup/admin'],
        ['label' => 'Invoice']
    ]"
/>

<div class="invoice bg-white border-4 border-indigo-200 border-t-purple-500 shadow rounded flex items-center justify-center py-10">
    <div class="bg-white w-[360px] rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 text-white text-center py-4 relative">
            <p class="text-sm font-medium">INVOICE</p>

            <div class="mt-2">
                <div class="w-20 h-20 mx-auto bg-white rounded-full flex items-center justify-center shadow-md">
                    @if ($invoice->status === 'success')
                        <i data-lucide="circle-check-big" class="w-10 h-10 text-green-600"></i>
                    @elseif ($invoice->status === 'pending')
                        <i data-lucide="timer" class="w-10 h-10 text-yellow-500"></i>
                    @else 
                        <i data-lucide="x-circle" class="w-10 h-10 text-red-600"></i>
                    @endif
                </div>

                <p class="text-xs mt-2 font-bold tracking-wide uppercase">
                    {{ strtoupper($invoice->status) }}
                </p>
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

                
                <button onclick="window.print()" class="btn w-full block bg-green-500 hover:bg-green-600 text-white text-center py-3 rounded-lg text-sm font-semibold shadow-md">
                🖨️ Cetak Invoice
                </button>

            </div>
        </div>
    </div>
</div>
@endsection
