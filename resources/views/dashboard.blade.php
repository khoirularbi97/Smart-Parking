@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gray-100">
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

 <!-- Stat Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 px-6">
    <!-- Terparkir -->
    <div class="bg-white border-4 border-indigo-200 border-l-purple-500 shadow-md rounded-lg p-6 flex items-center transition-transform duration-300 hover:scale-105">
        <div class="bg-blue-100 p-3 rounded-full mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3V3z" />
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Terparkir Sekarang</p>
            <p class="text-xl font-semibold">{{ $totalTerparkir ?? 0 }}</p>
        </div>
    </div>

    <!-- Masuk Hari Ini -->
    <div class="bg-white border-4 border-indigo-200 border-l-cyan-500 shadow-md rounded-lg p-6 flex items-center transition-transform duration-300 hover:scale-105">
        <div class="bg-green-100 p-3 rounded-full mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Masuk Hari Ini</p>
            <p class="text-xl font-semibold">{{ $totalMasukHariIni ?? 0 }}</p>
        </div>
    </div>

    <!-- Keluar Hari Ini -->
    <div class="bg-white border-4 border-indigo-200 border-l-sky-500 shadow-md rounded-lg p-6 flex items-center transition-transform duration-300 hover:scale-105">
        <div class="bg-red-100 p-3 rounded-full mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-4 4L5 7" />
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Keluar Hari Ini</p>
            <p class="text-xl font-semibold">{{ $totalKeluarHariIni ?? 0 }}</p>
        </div>
    </div>
</div>

<!-- Table & Chart -->
<div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-4">
<!-- Table -->
    <div class="row p-4">

        <div class="bg-white shadow-md rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-4">Top Up Saldo</h3>
            <div class="table-responsive">
                    <table class="w-full border-collapse ">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border px-4 py-2">No</th>
                                <th class="border px-4 py-2">Nama</th>
                                <th class="border px-4 py-2">Type</th>
                                <th class="border px-4 py-2">Tanggal</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                                @forelse ($histories as $item)
                                
                            <tr>
                                <td class="border px-4 py-2">{{ $histories->firstItem() + $loop->index }}</td>
                                <td class="border px-4 py-2">{{ $item->name }}</td>
                                <td class="border px-4 py-2">{{ $item->method }}</td>
                                <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}</td>
                                <td class="border px-4 py-2"> 
                                    Rp {{ number_format($item->amount, 2, ',', '.') }}</td>
                                <td class="border px-4 py-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $item->status == 'success' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                    {{ $item->status }}
                                </span>
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
                        {{ $histories->links() }}
                    </div>
            </div>
        </div>
    </div>
    


<!-- Chart Placeholder -->
    <div class="row p-4">

        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-xl font-semibold  mb-4">Keuntungan Bulanan</h3>
           
        <h2 class="mb-6 text-2xl text-center font-bold mb-10"></h2>
                    <div class="card shadow-sm mt-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Grafik Pendapatan & Pengeluaran Bulanan</h5>

                        </div>
                        <div class="card-body">
                            <canvas id="labaChart" height="100"></canvas>
                        </div>
                    </div>

                    <div class="mt-3">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card shadow-sm border-left-primary">
                                <div class="card-body">
                                    <h6 class="text-primary">Total Pendapatan Parkir</h6>
                                    <h4 class="font-weight-bold">Rp{{ number_format($data->sum(fn($d) => $d->total_kredit), 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm border-left-danger">
                                <div class="card-body">
                                    <h6 class="text-danger">Total Top-up (Pengeluaran)</h6>
                                    <h4 class="font-weight-bold">Rp{{ number_format($data->sum(fn($d) => $d->total_debit), 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm border-left-success">
                                <div class="card-body">
                                    <h6 class="text-success">Keuntungan Bersih</h6>
                                    <h4 class="font-weight-bold">Rp{{ number_format($data->sum(fn($d) => $d->laba), 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                   
        </div>
    </div>
</div>
</div>
</div>

<div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-4">

    <div class="row p-4">
        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-xl font-semibold  mb-4">Grafik Transaksi Harian</h3>
            <div class="max-w-4xl mx-auto p-4">
                <div class="relative w-full h-[360px]">
                    <canvas id="chartTransaksiHarian" class="!w-full !h-full"></canvas>
                </div>
            </div>
        </div>

    </div>


    <div class=" row p-4">
        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-xl font-semibold  mb-4">Grafik Parkir Harian</h3>
            <div class="max-w-4xl mx-auto p-4">
                <div class="relative w-full h-[360px]">
                    <canvas id="combinedChart" class="!w-full !h-full"></canvas>
                </div>
        </div>

        </div>

    </div>
 </div>
 </div>



@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

const ctx2= document.getElementById('labaChart').getContext('2d');

    const data2 = {
        labels: {!! json_encode($data->map(fn($d) => $d->bulan . '-' . $d->tahun)) !!},
        datasets: [
            {
                label: 'Kredit',
                data: {!! json_encode($data->map(fn($d) => $d->total_kredit)) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            },
            {
                label: 'Debit',
                data: {!! json_encode($data->map(fn($d) => $d->total_debit)) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.6)'
            },
            {
                label: 'Laba',
                data: {!! json_encode($data->map(fn($d) => $d->laba)) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.6)'
            }
        ]
    };

    const config = {
        type: 'bar',
        data: data2,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    new Chart(ctx2, config);

   

     const ctx3 = document.getElementById('chartTransaksiHarian').getContext('2d');

            const chart3 = new Chart(ctx3, {
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




const ctx = document.getElementById('combinedChart').getContext('2d');
    const combinedChart = new Chart(ctx, {
        type: 'bar', // Tipe dasar: bar (untuk kendaraan)
        data: {
            labels: {!! json_encode($dates) !!},
            datasets: [
                {
                    label: 'Jumlah Kendaraan',
                    data: {!! json_encode($total_kendaraan) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    yAxisID: 'y'
                },
                {
                    label: 'Total Biaya (Rp)',
                    data: {!! json_encode($totals) !!},
                    type: 'line', // Tipe line untuk biaya
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    yAxisID: 'y1',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            stacked: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Grafik Jumlah Kendaraan dan Total Biaya Parkir per Hari'
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Jumlah Kendaraan'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Total Biaya (Rp)'
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection
