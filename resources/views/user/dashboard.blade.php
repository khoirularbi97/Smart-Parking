@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
<!-- Header -->

<header class="bg-gradient-to-r from-purple-500 to-pink-500 text-white text-3xl font-bold py-7 px-10 rounded-2xl shadow-lg">
    <div class="max-w-7xl mx-auto py-6 px-4 flex justify-between items-center sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-900">Hai!   {{ Auth::user()->name }}</h1>
        
    </div>
</header>

<div class="min-h-screen bg-gradient-to-br from-purple-200 to-indigo-200 p-4">
    
    {{-- Saldo Utama --}}
    <div class="transition-transform duration-300 hover:scale-105 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-3xl text-white p-6 text-center shadow-xl mb-6 ">
        <div class="flex flex-col items-center justify-center space-y-2">
            <div class="text-center mt-2" >  
                <i data-lucide="banknote" class="text-yellow-500 mr-4 w-20 h-20"></i>
            </div>
            <div class="text-4xl font-bold">Rp {{ number_format(auth()->user()->saldo, 00, ',', '.') }}</div>
            <div class="mt-2 text-sm">Saldo saat ini</div>

        </div>
    </div>
    




    {{-- Kartu Info Parkir --}}
    <div class="space-y-5 mb-24">

        @foreach ($histories as $history)
        <div class="bg-white rounded-2xl shadow-lg p-5">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-400 to-pink-400"><i data-lucide="square parking" class="w-8 h-8 p-1"></i></div>
                    <div>
                        <p class="font-bold text-sm">{{ $history->parking_slot->name ?? 'Slot Tidak Diketahui' }}</p>
                       <p class="text-xs text-gray-500">
                    Masuk: {{ \Carbon\Carbon::parse($history->waktu_masuk)->format('d M Y H:i') }}
                </p>
            
                @php
                        $isAktif = $history->_Status == 'aktif' || $history->_Status == 1 ; // sesuaikan jika integer
                    @endphp

                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                        {{ $isAktif ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">
                        {{ $isAktif ? 'Aktif' : 'Selesai' }}
                    </span>
                    </div>
                </div>
                <div class="text-right text-purple-700 font-semibold">
                    Rp {{ number_format($history->biaya, 0, ',', '.') }}
                </div>
            </div>

           @php
     $createdAt = $history->created_at;
    $status = $history->_Status; // "aktif" atau "selesai"
    $waktuKeluar = $history->waktu_keluar; // bisa null jika aktif
@endphp

@if ($createdAt)
    <div class="w-full h-2 bg-purple-100 rounded-full overflow-hidden">
        <div id="progressBar_{{ $history->id }}" class="h-full bg-gradient-to-r from-purple-500 to-pink-500 rounded-full transition-all duration-500" style="width: 0%"></div>
    </div>

    <p class="text-xs text-purple-500 mt-1" id="progressText_{{ $history->id }}">
        Menghitung durasi parkir...
    </p>

    <script>
         document.addEventListener('DOMContentLoaded', function () {
            const createdAt = new Date("{{ $createdAt->format('Y-m-d H:i:s') }}");
            const status = "{{ $status }}";
           const waktuKeluar = "{{ $waktuKeluar ? \Carbon\Carbon::parse($waktuKeluar)->format('Y-m-d H:i:s') : '' }}";


            const progressBar = document.getElementById("progressBar_{{ $history->id }}");
            const progressText = document.getElementById("progressText_{{ $history->id }}");

            function updateProgress() {
                const endTime = status === 0 && waktuKeluar ? new Date(waktuKeluar) : new Date();
                const diffMs = endTime - createdAt;
                const diffMinutes = Math.floor(diffMs / 60000); // ms to minutes
                const percent = Math.min(100, (diffMinutes / 1440) * 100); // 1440 = 24 jam

                progressBar.style.width = percent + "%";
                progressText.innerText = `Parkir selama ${diffMinutes} menit (${percent.toFixed(1)}% dari 1 hari)`;
            }

            updateProgress(); // initial
            if (status === null ) {
                setInterval(updateProgress, 60000); // hanya update realtime jika aktif
            }
        });
    </script>
@else
    <div class="w-full h-2 bg-purple-100 rounded-full overflow-hidden">
        <div class="h-full bg-gray-300 rounded-full w-0"></div>
    </div>
    <p class="text-xs text-gray-500 mt-1">Waktu masuk belum tersedia</p>
@endif

</div>
@endforeach
        {{-- Slot Parkir --}}
    <h5 class="mb-1 text-white text-3xl font-bold py-6  mt-2">Slot Parkir</h5>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
    @foreach ($slots as $slot)
        <div class="p-4 rounded-lg shadow-md {{ $slot->is_available === 'tersedia' ? 'bg-green-100' : 'bg-red-100' }}">
            <h6 class="font-semibold">Slot {{ $slot->name }}</h6>
            <span class="inline-block px-2 py-1 mt-2 text-xs font-bold rounded-full 
                {{ $slot->is_available === 'tersedia' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                {{ ucfirst($slot->is_available) }}
            </span>
        </div>
    @endforeach

    </div>
    

    

</div>

@endsection