@extends('layouts.app')

@section('title', 'Riwayat Parkir')

@section('content')
<x-page-header2
    title=""
    :breadcrumbs="[
        ['label' => 'Home', 'url' => '/Riwayat parkir'],
        
    ]"
/>

    <div class="p-1 grid grid-cols-1 gap-4">

        
        <div class="bg-white border-4 border-indigo-200 border-t-cyan-500 shadow rounded overflow-x-auto p-6">
            <h1 class="text-2xl text-center font-bold mb-10">Riwayat Parkir</h1>
            <div class="flex justify-between overflow-x-auto">
                <div class="justify-between items-center mb-6">
                <form action="" method="GET" class="mb-4 flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari " class="border p-2 rounded w-auto">
                    <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Cari</button>
                </form>

                <button onclick="exportPDF()" class="flex bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded mt-2 ">
                    <i data-lucide="file-down"></i>pdf
                    </button>
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
        <canvas id="parkingChart" height="100"></canvas>
    </div>

        <div class="table-responsive shadow">
            <table class="rounded ">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">No.</th>
                        <th class="px-4 py-2 border">Aksi</th>
                        <th class="px-4 py-2 border">Nama</th>
                        <th class="px-4 py-2 border">Slot Parkir</th>
                        <th class="px-4 py-2 border">UID</th>
                        <th class="px-4 py-2 border">Waktu Masuk </th>
                        <th class="px-4 py-2 border">Gambar Masuk</th>
                        <th class="px-4 py-2 border">Waktu Keluar</th>
                        <th class="px-4 py-2 border">Gambar Keluar</th>
                        <th class="px-4 py-2 border">Durasi</th>
                        <th class="px-4 py-2 border">Biaya</th>
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

                                    <button onclick="window.location.href=" class="bg-gray-100 px-4 py-2 rounded hover:bg-cyan-300"><i data-lucide="square-pen" class="text-cyan-800"></i></button>
                                    </div>
                                    <div class="center">
                                            <button onclick="showConfirmModal({{ $riwayat->id }})" class="bg-gray-100 px-4 py-2 rounded hover:bg-red-300"><i data-lucide="trash-2" class="text-red-800"></i></button>
                                    

                                    </div>
                                    <div class="center">
                                    
                                    <button  onclick="" class="bg-gray-100 px-4 py-2 rounded hover:bg-yellow-300"><i data-lucide="printer" class="text-yellow-800"></i></button>
                                    
                                    </div>



                                </div>
                            </td>
                            <td class="px-4 py-2 border">{{ $riwayat->user->name}}</td>
                            <td class="px-4 py-2 border">{{ $riwayat->parking_slot->name}}</td>
                            <td class="px-4 py-2 border">{{ $riwayat->uid}}</td>
                            <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($riwayat->waktu_masuk)->format('d M Y H:i') }}</td>
                            <td class="px-4 py-2 border">
                           @if (Str::startsWith($riwayat->image_masuk, '/9j')) {{-- Cek awalan base64 (JPEG) --}}
                              <img src="data:image/jpeg;base64,{{ $riwayat->image_masuk }}" alt="Gambar" class="h-10 w-10 cursor-pointer rounded shadow" onclick="showImageModal(this.src)">
                          @else
                              <img src="{{ $riwayat->image_path }}" alt="Gambar">
                          @endif
                           
                          </td>
                          <td class="px-4 py-2 border">{{ $riwayat->waktu_keluar ? \Carbon\Carbon::parse($riwayat->waktu_keluar)->format('d M Y H:i') : '0000-00-00 00:00:00' }}
                          </td>
                          <td class="px-4 py-2 border">
                         @if (Str::startsWith($riwayat->image_keluar, '/9j')) {{-- Cek awalan base64 (JPEG) --}}
                            <img src="data:image/jpeg;base64,{{ $riwayat->image_keluar }}" alt="Gambar" class="h-10 w-10 cursor-pointer rounded shadow" onclick="showImageModal(this.src)">
                        @else
                            <img src="{{ $riwayat->image_path }}" alt="Gambar">
                        @endif
                         
                        </td>
                            <td class="px-4 py-2 border">{{ $riwayat->durasi}}</td>
                            <td class="px-4 py-2 border">Rp {{ number_format($riwayat->biaya, 2, ',', '.') }}</td>
                            <td class="px-4 py-2 border">{{ $riwayat->CreatedDate }}</td>
                            <td class="px-4 py-2 border">{{ $riwayat->CreatedBy }}</td>
                            <td class="px-4 py-2 border">{{ $riwayat->LastUpdateBy }}</td>
                            <td class="px-4 py-2 border">{{ $riwayat->LastUpdateDate }}</td>
                            <td class="px-4 py-2 border">{{ $riwayat->CompanyCode }}</td>
                            <td class="px-4 py-2 border"> 
                                <span class="px-2 py-1 rounded text-xs font-semibold 
                                    {{ $riwayat->_Status == '1' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                                    {{ $riwayat->_Status == '1' ? 'Success' : 'Menunggu' }}
                                </span>
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
         <!-- Image Modal -->

<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
     <!-- Modal box -->
  <div id="modalBox" class="bg-white p-6 rounded-xl shadow-lg transform scale-95 opacity-0 transition duration-300 ease-out w-full max-w-md">
    <h2 class="text-xl font-semibold mb-4">Detail Foto</h2>
    <img id="modalImage" src="" class="max-w-full max-h-[100vh] rounded-lg border-4 border-white">
    <p><strong>UID:</strong> <span id="modalOrderId">{{ $riwayat->uid }}</span></p>
    <p><strong>Status:</strong> <span id="modalStatus" class="px-2 py-1 rounded text-xs font-semibold 
    {{ $riwayat->Status == '1' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
    {{ $riwayat->Status == '1' ? 'Success' : 'Gagal' }}</span></p>
    <p><strong>Waktu:</strong> <span id="modalTransactionTime">
                          <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($riwayat->created_at)->format('d M Y H:i') }}</span></p>
    <button onclick="closeImageModal()" class="mt-4 bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">Tutup</button>
  </div>
    <span class="absolute top-4 right-6 text-white text-3xl cursor-pointer" onclick="closeImageModal()">&times;</span>
    
</div>

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
    function openModal() {
            const overlay = document.getElementById('modalOverlay');
            const modal = document.getElementById('modalBox');

            overlay.classList.remove('hidden');

            // Pakai timeout agar animasi bisa berjalan setelah visible
            setTimeout(() => {
                modal.classList.remove('scale-95', 'opacity-0');
                modal.classList.add('scale-100', 'opacity-100');
            }, 10);
            }
            function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(angka);
            }

            function closeModal() {
            const overlay = document.getElementById('modalOverlay');
            const modal = document.getElementById('modalBox');

            modal.classList.remove('scale-100', 'opacity-100');
            modal.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                overlay.classList.add('hidden');
            }, 300); // waktu sesuai dengan duration-300
            }
    

    function showImageModal(src) {
        document.getElementById('modalImage').src = src;
        document.getElementById('imageModal').classList.remove('hidden');
        const modal = document.getElementById('modalBox');
        modal.classList.add('scale-100', 'opacity-100');

    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
        const modal = document.getElementById('modalBox');

            modal.classList.remove('scale-100', 'opacity-100');
            modal.classList.add('scale-95', 'opacity-0');
    }

    // Tutup modal jika klik di luar gambar
    document.getElementById('imageModal').addEventListener('click', function (e) {
        if (e.target.id === 'imageModal') {
            closeImageModal();
            
        }
         

    });

    const ctx = document.getElementById('parkingChart').getContext('2d');

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

  
function downloadChartPDF() {
    domtoimage.toPng(document.getElementById('parkingChart')).then(function (dataUrl) {
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
        const canvas = document.getElementById('parkingChart');
        const image = canvas.toDataURL('image/png'); // Convert to Base64 PNG
        document.getElementById('chart_image').value = image;
        document.getElementById('pdfForm').submit();
    }

</script>


@endsection
