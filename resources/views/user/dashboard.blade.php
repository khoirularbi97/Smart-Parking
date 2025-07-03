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
         @php
            $waktuMasuk = \Carbon\Carbon::parse($history->waktu_masuk);
            $waktuKeluar = $history->waktu_keluar;
            $status =  $history->_Status == '1' ? 'Selesai' : 'Aktif' ;
            $isAktif = $status;
            $ratePerJam = 2000;
            $createdAt = $history->created_at;
        @endphp
        <div class="bg-white rounded-2xl shadow-lg p-5">
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-400 to-pink-400">
                <i data-lucide="square parking" class="w-8 h-8 p-1"></i>
            </div>
            <div>
                <p class="font-bold text-sm">{{ $history->parking_slot->name ?? 'Slot Tidak Diketahui' }}</p>
                <p class="text-xs text-gray-500">Masuk: {{ $waktuMasuk->format('d M Y H:i') }}</p>

                @if ($waktuKeluar)
                <p class="text-xs text-gray-500" id="keluar_{{ $history->id }}">
                    Keluar: {{ \Carbon\Carbon::parse($waktuKeluar)->format('d M Y H:i') }}
                </p>
                @else
                <p class="text-xs text-gray-500" id="keluar_{{ $history->id }}"></p>
                @endif

                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $status == 'Selesai' ? 'bg-gray-200 text-gray-700' : 'bg-green-100 text-green-800' }}">
                    {{ $status }}
                </span>
            </div>
        </div>
        <div class="text-right text-purple-700 font-semibold" id="biaya_{{ $history->id }}">
            Rp {{ number_format($history->biaya ?? 0, 0, ',', '.') }}
        </div>
    </div>
    
@if($createdAt)
    <div class="w-full h-2 bg-purple-100 rounded-full overflow-hidden">
        <div id="progressBar_{{ $history->id }}" class="h-full bg-gradient-to-r from-purple-500 to-pink-500 rounded-full transition-all duration-500" style="width: 0%"></div>
    </div>

    <p class="text-xs text-purple-500 mt-1" id="progressText_{{ $history->id }}">
        Menghitung durasi parkir...
    </p>


    <script>
          document.addEventListener('DOMContentLoaded', function () {
            const masuk = new Date("{{ $waktuMasuk->format('Y-m-d H:i:s') }}");
            const keluarRaw = "{{ $waktuKeluar }}";
            const status = "{{ $status }}";
            const ratePerJam = {{ $ratePerJam }};
            const id = "{{ $history->id }}";

            const progressBar = document.getElementById("progressBar_" + id);
            const progressText = document.getElementById("progressText_" + id);
            const biayaElem = document.getElementById("biaya_" + id);
            const keluarElem = document.getElementById("keluar_" + id);

            function update() {
                const now = new Date();
                const keluar = keluarRaw ? new Date("{{ \Carbon\Carbon::parse($waktuKeluar)->format('Y-m-d H:i:s') }}") : now;

                const diffMs = keluar - masuk;
                const diffMinutes = Math.floor(diffMs / 60000);
                const percent = Math.min(100, (diffMinutes / 1440) * 100);

                const jam = Math.floor(diffMinutes / 60);
                const menit = diffMinutes % 60;

                const biaya = Math.ceil(diffMinutes / 60) * ratePerJam;

                progressBar.style.width = percent + "%";
                progressText.innerText = `Parkir selama ${jam} jam ${menit} menit (${percent.toFixed(1)}% dari 1 hari)`;

                if (status === 'Aktif') {
                    biayaElem.innerText = `Rp ${biaya.toLocaleString('id-ID')}`;
                    keluarElem.innerText = `Keluar: -`;
                } else {
                    // final biaya tetap
                    biayaElem.innerText = `Rp {{ number_format($history->biaya, 0, ',', '.') }}`;
                }
            }

            update();
            if (status === null) {
                setInterval(update, 60000);
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