@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
<div class="flex items-center  bg-gradient-to-r from-pink-400 to-purple-500 shadow-xl p-6 mb-10">
     
      <h1 class="text-white font-semibold text-lg">Riwayat Transaksi</h1>
    </div>
  

    

    <div class="space-y-5 mb-24">
        @forelse ($histories as $history)
        <div class="bg-white rounded-2xl shadow-lg p-4">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center">
                        <i data-lucide="{{ $history->jenis=== 'debit' ? 'credit-card' : 'wallet-minimal' }}" class="text-white w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="font-bold text-purple-700 text-sm" >
                            {{-- <span class="
                                @if($history->Status == 1) text-green-500 
                                @elseif($history->Status == 0) text-yellow-500 
                                @else text-red-500 @endif
                            "> --}}
                                {{ ucfirst($history->keterangan) }}
                            </span>
                        </p>
                        <p class="text-xs text-gray-500">{{ $history->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                <div class="text-right font-semibold {{ $history->jenis=== 'debit' ? ' text-green-500 ' : 'text-red-500' }}">
                    <span class="">{{ $history->jenis=== 'debit' ? ' + ' : '-' }}
                        </span>
                    Rp {{ number_format($history->jumlah, 0, ',', '.') }}
                </div>
            </div>
        </div>
        @empty
        <div class="text-center text-gray-500 mt-20">
            <i data-lucide="file" class="mx-auto w-10 h-10 mb-2"></i>
            <p>Tidak ada transaksi ditemukan.</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $histories->links('vendor.pagination.tailwind') }}
    </div>

@endsection
