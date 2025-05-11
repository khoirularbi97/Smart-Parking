@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    
    <h2 class="text-2xl font-bold">Dashboard</h2>
<!-- Navbar -->

<!-- Dashboard Content -->
<div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
         <div class="bg-white border-4 border-indigo-200 border-l-blue-500 shadow-md rounded-lg p-6 flex items-center">
            <i data-lucide="users" class="w-10 h-10 text-blue-500 mr-4"></i>
            <div>
                 <h3 class="text-gray-500">Jumlah Member</h3>
                 <p class="text-2xl font-bold">{{ $member}}</p>
            </div>
        </div>

        <div class="bg-white border-4 border-indigo-200 border-l-green-500 shadow-md rounded-lg p-6 flex items-center">
            <i data-lucide="shield-check" class="w-10 h-10 text-green-500 mr-4"></i>
            <div>
                <h3 class="text-gray-500">Jumlah Admin</h3>
                <p class="text-2xl font-bold">{{ $admin}}</p>
            </div>
        </div>

        <div class="bg-white border-4 border-indigo-200 border-l-yellow-500 shadow-md rounded-lg p-6 flex items-center">
        <i data-lucide="credit-card" class="w-10 h-10 text-yellow-500 mr-4"></i>
            <div>
                <h3 class="text-gray-500">Data Transaksi Kredit</h3>
                 <p class="text-2xl font-bold">{{$kredit}}</p>

            </div>
        </div>

        <div class="bg-white border-4 border-indigo-200 border-l-red-500 shadow-md rounded-lg p-6 flex items-center">
        <i data-lucide="banknote" class="w-10 h-10 text-red-500 mr-4"></i>
            <div>
                <h3 class="text-gray-500">Data Transaksi Debit</h3>
                <p class="text-2xl font-bold">{{$debit}}</p>
            </div>
        </div>
 </div>
<!-- Table & Chart -->
<div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-4">
<!-- Table -->
    <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-4">Top Up Saldo</h3>
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


<!-- Chart Placeholder -->
    <div class="bg-white shadow-md rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-4">Data Transaksi</h3>
    <div class="flex items-center justify-center ">
        <div class="card">
   
        </div>
    </div>
    <div class="w-45">
  
    <canvas id="transaksiChart"></canvas>
   
   

    </div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    var debit = {{ $debit ?? 0 }};
    var kredit = {{ $kredit ?? 0 }};
   
var ctx = document.getElementById('transaksiChart').getContext('2d');
var transaksiChart = new Chart(ctx, {
type: 'doughnut',
data: {
labels: ['Transaksi Debit', 'Transaksi Kredit'],
datasets: [{
data: [{{ $debit }}, {{ $kredit }}],
backgroundColor: ['#007bff', '#dc3'],
}]
},
options: {
responsive: true,
maintainAspectRatio: false
}

});
</script>


</div>
</div>
</div>
</div>
@endsection
