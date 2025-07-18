@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<x-page-header
    title=""
    :breadcrumbs="[
        ['label' => 'Home', 'url' => '/dashboard'],
        ['label' => 'Transaksi ', 'url' => '/transaksi'],
        
    ]"
/>

    <div class="p-1 grid grid-cols-1 gap-4 ">

        
        <div class="bg-white border-4 border-indigo-200 border-t-blue-500 shadow-xl rounded-xl overflow-x-auto p-6 mt-1">
            <h1 class="text-2xl text-center font-bold mb-10">Riwayat Transaksi</h1>
            <div class="flex justify-between overflow-x-auto">
                <div class="justify-between items-center mb-6">
                <form action="" method="GET" class="mb-4 flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email..." class="border p-2 rounded w-auto">
                    <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Cari</button>
                </form>
                
                <a href="{{ route('admin/transaksi/create') }}" class="bg-sky-400 hover:bg-sky-200 px-4 py-2 rounded gap-4">+Tambah Transaksi</a>
                 {{-- <a href="{{ route('admin.transaksis.exportPdf', request()->query()) }}" target="_blank"
                        class="bg-red-500 text-white px-4 py-2 rounded">Export pdf</a> --}}

                  <button onclick="exportPDF()" id="pdfBtn" type="button" class="flex bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded mt-2 ">
                    <i data-lucide="file-down"></i>pdf
                    </button>
                </div>
               
                

                    <form id="pdfForm" method="POST" action="{{ route('admin.transaksi.export-pdf', request()->query()) }}">
                        @csrf
                        <input type="hidden" name="chart_image" id="chart_image">
                        <input type="hidden" name="chart_image_donat" id="chart_image_donat">
                    </form>
               


                <form method="GET" action="" class="flex flex-wrap md:flex-nowrap gap-4 items-end mb-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium">Dari Tanggal</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                                class="border rounded px-2 py-1">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium">Sampai Tanggal</label>
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
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
                    <h3 class="text-lg text-center font-semibold mb-2">Grafik Transaksi</h3>
                <canvas id="transaksiChart" height="100"></canvas>
           
        </div>
        <div class="bg-white p-4 rounded shadow mb-6">
             <div  class="flex justify-center">
                <div style="max-width: 300px; width: 100%;">
                    <h3 class="text-lg text-center font-semibold mb-2">Jenis Transaksi</h3>
                    <canvas id="methodChart" width="300" height="300"></canvas>

                </div>
            </div>
        </div>
       
            
            


        <div class="table-responsive shadow">
            <table class="relative min-w-full rounded ">
                <thead class="sticky top-0 bg-white z-10">

                    <tr class=" bg-gray-100">
                        <th class="px-4 py-2 border">No.</th>
                        <th class="px-4 py-2 border">Aksi</th>
                        <th class="px-4 py-2 border">UID</th>
                        <th class="px-4 py-2 border">Nama</th>
                        <th class="px-4 py-2 border">Jenis</th>
                        <th class="px-4 py-2 border">Keterangan</th>
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
                    @forelse ($transaksis as $transaksi)
                        <tr>
                            <td class="px-4 py-2 border">{{ $transaksis->firstItem() + $loop->index }}</td>
                            <td class="p-1 border">
                                <div class="flex justify-center-safe gap-1">
                                    <div class="center">

                                    <button onclick="window.location.href='{{ route('admin.transaksi.edit', $transaksi->id) }}'" class="bg-gray-100 p-1 rounded hover:bg-cyan-300"><i data-lucide="square-pen" class="text-cyan-800"></i></button>
                                    </div>
                                    <div class="center">
                                            
                                             <button onclick="showConfirmModal({{ $transaksi->id }})" class="bg-gray-100 p-1 rounded hover:bg-red-300"   title="Hapus Transaksi"><i data-lucide="trash-2" class="text-red-800"></i></button>

                                            <form  id="delete-form-{{ $transaksi->id }}" action="{{ route('admin.transaksi.destroy', $transaksi->id) }}" class="hidden" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                </form>
                                    
                                    

                                    </div>
                                    <div class="center">
                                    
                                    <button  onclick="" class="bg-gray-100 p-1 rounded hover:bg-yellow-300"><i data-lucide="eye" class="text-yellow-800"></i></button>
                                    
                                    </div>



                                </div>
                            </td>
                            <td class="px-4 py-2 border">{{ $transaksi->uid }}</td>
                            <td class="px-4 py-2 border">{{ $transaksi->nama }}</td>
                            <td class="px-4 py-2 border">{{ $transaksi->jenis }}</td>
                            <td class="px-4 py-2 border">{{ $transaksi->keterangan }}</td>
                            <td class="px-4 py-2 border">{{ $transaksi->created_at }}</td>
                            <td class="px-4 py-2 border">{{ $transaksi->CreatedBy }}</td>
                            <td class="px-4 py-2 border">{{ $transaksi->LastUpdateBy }}</td>
                            <td class="px-4 py-2 border">{{ $transaksi->LastUpdateDate }}</td>
                            <td class="px-4 py-2 border">{{ $transaksi->CompanyCode }}</td>
                            <td class="px-4 py-2 border"> 
                                <span class="px-2 py-1 rounded text-xs font-semibold 
                                    {{ $transaksi->Status == '1' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                    {{ $transaksi->Status == '1' ? 'Success' : 'Gagal' }}
                                </span>
                                </td>
                                <td class="px-4 py-2 border">{{ $transaksi->IsDeleted }}</td>
                                <td class="px-4 py-2 border">Rp {{ number_format($transaksi->jumlah, 2, ',', '.') }}</td>
                                
                            
                        </tr>
                        @empty
                        <tr>
                            <td class="border text-center px-4 py-2" colspan="13">Not found</td>
                            
                        </tr>
                    
                @endforelse
                </tbody>
            </table>
            <div class="p-4">
               {{ $transaksis->appends(request()->query())->links() }}

            </div>
        </div>
       
    </div>
   
                


        <form  id="deleteForm"  class="hidden" method="POST">
        @csrf
        @method('DELETE')
        </form>
         <x-popup-delete></x-popup-delete>
</div>


@if(session(''))
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
 @php
    $labels = ['Debit', 'Kredit'];
    $values = [$debitCount, $kreditCount];
@endphp
<script>
    
    let deleteUserId = null;

    function showConfirmModal1(userId) {
        deleteUserId = userId;
        document.getElementById('confirmModal').classList.remove('hidden');
    }

    function hideConfirmModal1() {
        document.getElementById('confirmModal').classList.add('hidden');
    }

    function submitDelete1() {
    const form = document.getElementById('deleteForm');
    form.action = '{{ url("admin/transaksi") }}/' + deleteUserId;
    form.submit();
}

    const ctx = document.getElementById('transaksiChart').getContext('2d');

    const transaksiChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($dates) !!},
            datasets: [{
                label: 'Total Transaksi (Rp)',
                data: {!! json_encode($totals) !!},
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
const labelsRaw = {!! json_encode($labels) !!};
const valuesRaw = {!! json_encode($values) !!};
const labelsWithCounts = labelsRaw.map((label, index) => `${label}: ${valuesRaw[index]}`);
const ctx2 = document.getElementById('methodChart').getContext('2d');
const methodChart = new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: labelsWithCounts,
        datasets: [{
            data: valuesRaw,
            backgroundColor: ['#38bdf8', '#facc15'],
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
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
      const btn = document.getElementById('pdfBtn');
        btn.disabled = true;
        btn.classList.remove('bg-blue-600');
        btn.classList.add('bg-gray-400');

        // Tambahkan spinner ke dalam button
        btn.innerHTML = `
            <span class="spinner"></span>
            Exporting...
        `;

        const canvas = document.getElementById('transaksiChart');
        const canvasDonat = document.getElementById('methodChart');
        const image = canvas.toDataURL('image/png'); // Convert to Base64 PNG
        const imageDonat = canvasDonat.toDataURL('image/png'); // Convert to Base64 PNG
        document.getElementById('chart_image').value = image;
        document.getElementById('chart_image_donat').value = imageDonat;
        document.getElementById('pdfForm').submit();
    }

</script>


@endsection