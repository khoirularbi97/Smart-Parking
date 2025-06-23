@extends('layouts.app')

@section('title', 'Riwayat Parkir')

@section('content')
<x-page-header2
    title=""
    :breadcrumbs="[
        ['label' => 'Home', 'url' => '/Riwayat parkir'],
        
    ]"
/>

    <div class="p-6 grid grid-cols-1 gap-4">

        
        <div class="bg-white shadow rounded overflow-x-auto p-6">
            <div class="flex justify-between overflow-x-auto">
                <div class="justify-between items-center mb-6">
                <form action="" method="GET" class="mb-4 flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email..." class="border p-2 rounded w-auto">
                    <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Cari</button>
                </form>
                
                <a href="{{ route('admin.riwayat-parkir.create') }}" class="bg-gray-200 hover:g-sky-200 px-4 py-2 rounded">Tambah Transaksi</a>
                </div>
                <div class="mt-4 gap-5 mb-4">
                    <a href="" target="_blank"
                        class="bg-red-500 text-white px-4 py-2 rounded">Export Table Only</a>

                  <button onclick="exportPDF()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded mt-5 mb-5">Export With Chart</button>
                </div>
                

                    <form id="pdfForm" method="POST" action="">
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
                    </form>
        </div>
        <div class="bg-white p-4 rounded shadow mb-6">
    <h3 class="text-lg font-semibold mb-2">Grafik Transaksi</h3>
        <canvas id="transaksiChart" height="100"></canvas>
    </div>

        <div class="table-responsive shadow">
            <table class="relative min-w-full rounded ">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">No.</th>
                        <th class="px-4 py-2 border">Slot Parkir</th>
                        <th class="px-4 py-2 border">Total Durasi </th>
                        <th class="px-4 py-2 border">Jumlah Transaksi</th>
                        <th class="px-4 py-2 border">total biaya</th>
                        <th class="px-4 py-2 border">Jumlah</th>
                        <th class="px-4 py-2 border">Keterangan</th>
                        <th class="px-4 py-2 border">CreatedDate</th>
                        <th class="px-4 py-2 border">CreatedBy</th>
                        <th class="px-4 py-2 border">LastUpdateBy</th>
                        <th class="px-4 py-2 border">LastUpdateDate</th>
                        <th class="px-4 py-2 border">CompanyCode</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">IsDeleted</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayat_parkir as $riwayat)
                        <tr>
                            <td class="px-4 py-2 border">{{ $riwayat_parkir->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-2 border">
                                <div class="flex justify-center-safe gap-4">
                                    <div class="center">

                                    <button onclick="window.location.href=" class="bg-gray-100 px-4 py-2 rounded hover:bg-cyan-300"><i data-lucide="square-pen"></i></button>
                                    </div>
                                    <div class="center">
                                            <button onclick="showConfirmModal({{ $riwayat->id }})" class="bg-gray-100 px-4 py-2 rounded hover:bg-red-300"><i data-lucide="trash-2"></i></button>
                                    

                                    </div>
                                    <div class="center">
                                    
                                    <button  onclick="" class="bg-gray-100 px-4 py-2 rounded hover:bg-yellow-300"><i data-lucide="printer"></i></button>
                                    
                                    </div>



                                </div>
                            </td>
                            <td class="px-4 py-2 border">{{ $riwayat->parking_slot_id}}</td>
                            <td class="px-4 py-2 border">{{ $riwayat->total_durasi}}</td>
                            <td class="px-4 py-2 border">{{ $riwayat->jumlah_transaksi}}</td>
                            <td class="px-4 py-2 border">Rp {{ number_format($riwayat->total_biaya, 2, ',', '.') }}</td>
                            <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($riwayat->created_at)->format('d M Y H:i') }}</td>
                            <td class="px-4 py-2 border">{{ $riwayat->CreatedDate }}</td>
                            <td class="px-4 py-2 border">{{ $riwayat->CreatedBy }}</td>
                            <td class="px-4 py-2 border">{{ $riwayat->LastUpdateBy }}</td>
                            <td class="px-4 py-2 border">{{ $riwayat->LastUpdateDate }}</td>
                            <td class="px-4 py-2 border">{{ $riwayat->CompanyCode }}</td>
                            <td class="px-4 py-2 border"> 
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $riwayat->Status == '1' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                    {{ $riwayat->Status }}
                                </span></td>
                            <td class="px-4 py-2 border">{{ $riwayat->IsDeleted }}</td>
                            
                            
                        </tr>
                        @empty
                        <tr>
                            <td class="border text-center px-4 py-2" colspan="13">Not found</td>
                            
                        </tr>
                    
                @endforelse
                </tbody>
            </table>
            <div class="p-4">
                {{ $riwayat_parkir->links() }}
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
    form.action = '{{ url("admin/transaksi") }}/' + deleteUserId;
    form.submit();
}

    const ctx = document.getElementById('transaksiChart').getContext('2d');

    const transaksiChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {},
            datasets: [{
                label: 'Total Transaksi (Rp)',
                data: {},
                borderColor: 'rgba(59, 130, 246, 1)', // Tailwind blue-500
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
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
    domtoimage.toPng(document.getElementById('transaksiChart')).then(function (dataUrl) {
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
        const canvas = document.getElementById('transaksiChart');
        const image = canvas.toDataURL('image/png'); // Convert to Base64 PNG
        document.getElementById('chart_image').value = image;
        document.getElementById('pdfForm').submit();
    }

</script>


@endsection
