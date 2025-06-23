@extends('layouts.app')

@section('title', 'Top Up')

@section('content')
<x-page-header-topup
    title=""
    :breadcrumbs="[
        ['label' => 'Home', 'url' => '/topup/admin'],
        
    ]"
/>

    <div class="p-1 grid grid-cols-1 gap-1">

        <div class="bg-white border-4 border-indigo-200 border-t-purple-500 shadow rounded overflow-x-auto p-6 mt-1 card-header">
            <h1 class="text-2xl text-center font-bold mb-10">Riwayat Top Up</h1>
            <div class="flex justify-between overflow-x-auto">
            <div class="justify-between items-center mb-6">
            <form action="" method="GET" class="mb-4 flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari.." class="border p-2 rounded w-30">
                <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Cari</button>
            </form>
            
            <a href="{{ route('create.topup') }}" class="bg-sky-600 hover:bg-cyan-500 text-white px-4 py-2 rounded">+Top Up Member</a>
            
                  <button onclick="exportPDF()" class="flex bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded mt-2 ">
                    <i data-lucide="file-down"></i>pdf
                    </button>
               
                
                </div>

                    <form id="pdfForm" method="POST" action="{{ route('admin.topup.export-pdf') }}">
                        @csrf
                        <input type="hidden" name="chart_image" id="chart_image">
                    </form>
               


                <form method="GET" action="" class="flex flex-wrap md:flex-nowrap gap-4 items-end mb-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium">Dari Tanggal</label>
                            <input type="date" name="start_date" id="start_date" value=""
                                class="border rounded px-2 py-1">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium">Sampai Tanggal</label>
                            <input type="date" name="end_date" id="end_date" value=""
                                class="border rounded px-2 py-1">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300"> <i data-lucide="funnel" class=""></i></button>
                        </div>
                         <div class="mt-4 gap-5 mb-4">
                        </div>
                    </form>
                   
        </div>
        <div class="bg-white p-4 rounded shadow mb-6">
    <h3 class="text-lg text-center font-semibold mb-2">Grafik Top Up</h3>
        <canvas id="topupChart" height="100"></canvas>
    </div>
            
            <div class="table-responsive">
            <table class="relative min-w-full rounded-lg shadow">
                <thead >
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">No.</th>
                        <th class="px-4 py-2 border">Aksi</th>
                        <th class="px-4 py-2 border">Nama</th>
                        <th class="px-4 py-2 border">Order ID</th>
                        <th class="px-4 py-2 border">Type</th>
                        <th class="px-4 py-2 border">CreatedDate</th>
                        <th class="px-4 py-2 border">CreatedBy</th>
                        <th class="px-4 py-2 border">LastUpdateBy</th>
                        <th class="px-4 py-2 border">LastUpdateDate</th>
                        <th class="px-4 py-2 border">CompanyCode</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">IsDeleted</th>
                        <th class="px-4 py-2 border">Jumlah</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @forelse ($topup as $topups)
                        <tr>
                            <td class="px-4 py-2 border">{{$topup->firstItem() + $loop->index }}</td>
                            <td class="p-1 border">
                                <div class="flex justify-center-safe gap-1 p-1">
                                    <div class="center">

                                    <button onclick="window.location.href='{{ route('edit.topup', $topups->id) }}'" class="bg-gray-100 p-1 rounded hover:bg-cyan-300"><i data-lucide="square-pen" class="text-cyan-800"></i></button>
                                    </div>
                                    <div class="center">
                                            <button onclick="showConfirmModal({{ $topups->id }})" class="bg-gray-100 p-1 rounded hover:bg-red-300"><i data-lucide="trash-2" class="text-red-800"></i></button>
                                    

                                    </div>
                                    <div class="center">
                                    
                                    <button  onclick="window.location.href='{{ route('invoice.show', $topups->order_id) }}'" class="bg-gray-100 p-1 rounded hover:bg-yellow-300"><i data-lucide="eye" class="text-yellow-800"></i></button>
                                    
                                    </div>



                                </div>
                            </td>
                            <td class="px-4 py-2 border">{{ $topups->name }}</td>
                            <td class="px-4 py-2 border">{{ $topups->order_id }}</td>
                            <td class="px-4 py-2 border">{{ $topups->method }}</td>
                            <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($topups->created_at)->format('d M Y H:i') }}</td>
                            <td class="px-4 py-2 border">{{ $topups->CreatedBy }}</td>
                            <td class="px-4 py-2 border">{{ $topups->LastUpdateBy }}</td>
                            <td class="px-4 py-2 border">{{ $topups->update_at }}</td>
                            <td class="px-4 py-2 border">{{ $topups->CompanyCode }}</td>
                            <td class="px-4 py-2 border">
                                <span class="px-2 py-1 rounded text-xs font-semibold 
                                    @if($topups->status == 'success') 
                                        bg-green-200 text-green-800 
                                    @elseif($topups->status == 'pending') 
                                        bg-yellow-200 text-yellow-800 
                                    @else 
                                        bg-red-200 text-red-800 
                                    @endif">
                                    {{ ucfirst($topups->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 border">{{ $topups->IsDeleted }}</td>
                            <td class="px-4 py-2 border">Rp {{ number_format($topups->amount, 2, ',', '.') }}</td>
                            
                            
                        </tr>
                        @empty
                        <tr>
                            <td class="border text-center px-4 py-2" colspan="13">Not found</td>
                            
                        </tr>
                    
                @endforelse
                </tbody>
            </table>
            <div class="p-4">
                {{ $topup->links() }}
            </div>
        </div>
    </div>
   
                


        <form  id="deleteForm"  class="hidden" method="POST">
        @csrf
        @method('DELETE')
        </form>
         <x-popup-delete></x-popup-delete>
</div>
@if(session('success'))
<x-pop-up></x-pop-up>

<script>
    // Fungsi untuk menampilkan alert
    function showAlert() {
      const alert = document.getElementById('successAlert');
      alert.classList.remove('hidden');
  
      // Otomatis hilang setelah 3 detik
      setTimeout(() => {
        alert.classList.add('hidden');
      }, 3000);
    }
  
    // Fungsi untuk menutup manual
    function closeAlert() {
      document.getElementById('successAlert').classList.add('hidden');
    }
  
    // Contoh pemanggilan saat halaman dimuat (bisa ubah sesuai kebutuhan)
    window.onload = function () {
      showAlert(); // panggil hanya jika ada session success
    };
  </script>
@endif
<script>
    
    let deleteUserId = null;

    function showConfirmModal(userId) {
        deleteUserId = userId;
        document.getElementById('confirmModal').classList.remove('hidden');
    }

    function hideConfirmModal() {
        document.getElementById('confirmModal').classList.add('hidden');
    }

    function submitDelete() {
    const form = document.getElementById('deleteForm');
    form.action = '{{ url("topup/admin/delete") }}/' + deleteUserId;
    form.submit();
}
const ctx = document.getElementById('topupChart').getContext('2d');

    const transaksiChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($dates) !!},
            datasets: [{
                label: 'Total Transaksi (Rp)',
                data: {!! json_encode($totals) !!},
                borderColor: 'rgba(10, 130, 20, 1)', // Tailwind blue-500
                backgroundColor: 'rgba(10, 130, 25, 0.2)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let value = context.raw;
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
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

  
function downloadChartPDF() {
    domtoimage.toPng(document.getElementById('topupChart')).then(function (dataUrl) {
        const docDefinition = {
            content: [
                { text: 'Laporan Transaksi', style: 'header' },
                {
                    image: dataUrl,
                    width: 500
                }
            ],
            styles: {
                header: {
                    fontSize: 18,
                    bold: true,
                    marginBottom: 15
                }
            }
        };
        pdfMake.createPdf(docDefinition).download("laporan-transaksi-grafik.pdf");
    });
}

function exportPDF() {
        const canvas = document.getElementById('topupChart');
        const image = canvas.toDataURL('image/png'); // Convert to Base64 PNG
        document.getElementById('chart_image').value = image;
        document.getElementById('pdfForm').submit();
    }

</script>


@endsection