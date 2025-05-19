@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    
    <h2 class="text-2xl font-bold">Dashboard</h2>
<!-- Navbar -->

<!-- Dashboard Content -->

<div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

    <div class="transition-transform duration-300 hover:scale-105">
        <a href="{{ route('admin.member') }}">
        <div class="bg-white border-4 border-indigo-200 border-l-blue-500 shadow-md rounded-lg p-6 flex items-center">
            <i data-lucide="users" class="w-10 h-10 text-blue-500 mr-4"></i>
            <div>
                <h3 class="text-gray-500">Jumlah Member</h3>
                <p class="text-2xl font-bold">{{ $member}}</p>
            </div>
        </div>
        </a>
    </div>
    <div class="transition-transform duration-300 hover:scale-105">
        <div class="bg-white border-4 border-indigo-200 border-l-green-500 shadow-md rounded-lg p-6 flex items-center">
            <i data-lucide="shield-check" class="w-10 h-10 text-green-500 mr-4"></i>
            <div>
                <h3 class="text-gray-500">Jumlah Admin</h3>
                <p class="text-2xl font-bold">{{ $admin}}</p>
            </div>
        </div>

    </div>
    <div class="transition-transform duration-300 hover:scale-105">
        <a href="{{ route('transaksi') }}">
        <div class="bg-white border-4 border-indigo-200 border-l-yellow-500 shadow-md rounded-lg p-6 flex items-center">
        <i data-lucide="credit-card" class="w-10 h-10 text-yellow-500 mr-4"></i>
            <div>
                <h3 class="text-gray-500">Data Transaksi Kredit</h3>
                <p class="text-2xl font-bold">{{$kreditCount}}</p>
    
            </div>
        </div>
        </a>
    </div>
    <div class="transition-transform duration-300 hover:scale-105">
        <a href="{{ route('transaksi') }}">
        <div class="bg-white border-4 border-indigo-200 border-l-red-500 shadow-md rounded-lg p-6 flex items-center">
        <i data-lucide="banknote" class="w-10 h-10 text-red-500 mr-4"></i>
            <div>
                <h3 class="text-gray-500">Data Transaksi Debit</h3>
                <p class="text-2xl font-bold">{{$debitCount}}</p>
            </div>
        </div>
        </a>
    </div>



 </div>
<!-- Table & Chart -->
<div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-4">
<!-- Table -->
    <div class="transition-transform duration-300 hover:scale-105">

        <div class="bg-white shadow-md rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-4">Top Up Saldo</h3>
            <div class="table-responsive">
                    <table class="w-full border-collapse ">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border px-4 py-2">No</th>
                                <th class="border px-4 py-2">UID</th>
                                <th class="border px-4 py-2">Nama</th>
                                <th class="border px-4 py-2">Saldo</th>
                                <th class="border px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                                @forelse ($total as $item)
                                
                            <tr>
                                <td class="border px-4 py-2">{{$loop->iteration}}</td>
                                <td class="border px-4 py-2">{{ $item->uid }}</td>
                                <td class="border px-4 py-2">{{ $item->name }}</td>
                                <td class="border px-4 py-2"> 
                                    Rp {{ number_format($item->saldo, 2, ',', '.') }}</td>
                                <td class="border px-4 py-2 text-center">
                                    <button class="bg-green-500 text-white px-2 py-1 rounded"><i data-lucide="circle-dollar-sign"></i></button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="border px-4 py-2" colspan="5">Not found</td>
                                
                            </tr>
                                
                            @endforelse
                        </tbody>
                    </table>
            
                    <div class="p-4">
                        {{ $total->links() }}
                    </div>
            </div>
        </div>
    </div>
    


<!-- Chart Placeholder -->
    <div class="transition-transform duration-300 hover:scale-105">

        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-4">Data Transaksi</h3>
            <div class="flex items-center justify-center ">
                <div class="card">
    
                </div>
            </div>
            <div class="w-45 h-64">
    
                <canvas id="transaksiChart"></canvas>
    
        
            </div>
        </div>
    </div>

    <div class="transition-transform duration-300 hover:scale-105">
        <div class="bg-white shadow-md rounded-lg p-4">
            <div class="my-6">
                <h3 class="text-xl font-semibold  mb-4">Grafik Transaksi Harian</h3>
                <div class="max-w-4xl h-[300px] mx-auto p-4 ">
                    
                    <canvas id="chartTransaksiHarian"></canvas>
                </div>
            </div>
        </div>

    </div>



</div>
@push('scripts')
<script>
            const ctx1 = document.getElementById('chartTransaksiHarian').getContext('2d');

            const chart1 = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($transaksiPerHari->pluck('tanggal')) !!},
                    datasets: [
                        {
                            label: 'Debit',
                            data: {!! json_encode($transaksiPerHari->pluck('total_debit')) !!},
                            backgroundColor: 'rgba(34, 197, 94, 0.7)', // green
                        },
                        {
                            label: 'Kredit',
                            data: {!! json_encode($transaksiPerHari->pluck('total_kredit')) !!},
                            backgroundColor: 'rgba(59, 130, 246, 0.7)', // blue
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Statistik Transaksi per Hari'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    }
                }
            });

    var debit = {{ $debitCount ?? 0 }};
    var kredit = {{ $kreditCount ?? 0 }};
   
var ctx2 = document.getElementById('transaksiChart').getContext('2d');
var transaksiChart = new Chart(ctx2, {
type: 'doughnut',
data: {
labels: ['Transaksi Debit', 'Transaksi Kredit'],
datasets: [{
data: [{{ $debitCount }}, {{ $kreditCount }}],
backgroundColor: ['#007bff', '#dc3'],
}]
},
options: {
responsive: true,
maintainAspectRatio: false
}

});
</script>
@endpush
@endsection
