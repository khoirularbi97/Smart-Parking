@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
<div>
   <div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 flex justify-between items-center sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900">Hai! {{ Auth::user()->name }}</h1>
            
        </div>
    </header>

    <!-- Main Content -->
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Card: Saldo -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Saldo Anda</h2>
                <p class="text-2xl font-bold text-indigo-600">Rp {{ number_format(Auth::user()->saldo ?? 0, 0, ',', '.') }}</p>
            </div>

            <!-- Card: Transaksi Terakhir -->
            <div class="bg-white shadow rounded-lg p-6 md:col-span-2">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Transaksi Terakhir</h2>
                <ul class="divide-y divide-gray-200">
                    {{-- @forelse ($transaksis as $trx)
                        <li class="py-2 flex justify-between">
                            <span>{{ $trx->jenis == 'kredit' ? 'Pengisian Saldo' : 'Pembayaran Parkir' }}</span>
                            <span class="{{ $trx->jenis == 'kredit' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $trx->jenis == 'kredit' ? '+' : '-' }} Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                            </span>
                        </li>
                    @empty
                        <li class="text-gray-500 text-sm">Belum ada transaksi.</li>
                    @endforelse --}}
                </ul>
            </div>

        </div>

        <!-- Aksi -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
            <div class="bg-white shadow rounded-lg p-6 flex flex-wrap gap-4">
                <a href="" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Tambah Transaksi</a>
                <a href="" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">Edit Profil</a>
            </div>
        </div>
    </div>
</div>
</div>


@endsection