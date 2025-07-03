@extends('layouts.app')

@section('title', 'Riwayat Parkir')

@section('content')
<x-page-header
    title=""
    :breadcrumbs="[
       ['label' => 'Home', 'url' => '/dashboard'],
        ['label' => 'Riwayat parkir']
        
    ]"
/>

    <div class="p-1 grid grid-cols-1 gap-4">

        
        <div class="bg-white border-4 border-indigo-200 border-t-cyan-500 shadow-xl rounded-xl overflow-x-auto p-6">
            <h1 class="text-2xl text-center font-bold mb-10">Riwayat Parkir</h1>
            <div class="flex justify-between overflow-x-auto">
                <div class="justify-between items-center mb-6">
                <form action="" method="GET" class="mb-4 flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari " class="border p-2 rounded w-auto">
                    <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Cari</button>
                </form>

                <button onclick="exportPDF()" id="pdfBtn" type="button" class="flex bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded mt-2 ">
                    <i data-lucide="file-down"></i>pdf
                    </button>
                </div>
                
         
                

                    <form id="pdfForm" method="POST" action="{{ route('admin.riwayat_parkir.export-pdf', request()->query()) }}">
                        @csrf
                        <input type="hidden" name="chart_image_biaya" id="chart_image_biaya">
                        <input type="hidden" name="chart_image_kendaraan" id="chart_image_kendaraan">
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
            <h3 class="text-lg font-semibold mb-2">Grafik Riwayat Parkir</h3>
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
                                             <form  id="delete-form-{{ $riwayat->id }}" action="{{ route('admin.riwayat-parking.destroy', $riwayat->id) }}"  class="hidden" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                </form>
                                    

                                    </div>
                                    <div class="center">
                                    
                                    <button
                                        onclick="showImageModal(
                                            '{{$riwayat->image_masuk ?? '-'  }}',
                                            '{{$riwayat->image_keluar ?? '-'  }}',
                                            '{{ $riwayat->user->name ?? '-'  }}',
                                            '{{ $riwayat->uid ?? '-' }}',
                                            '{{ $riwayat->_Status ?? '-' }}',
                                            '{{ $riwayat->waktu_masuk ? \Carbon\Carbon::parse($riwayat->waktu_masuk)->format('d M Y H:i') : '-' }}',
                                            '{{ $riwayat->waktu_keluar ? \Carbon\Carbon::parse($riwayat->waktu_keluar)->format('d M Y H:i') : '-' }}'
                                        )"
                                        class="bg-gray-100 px-4 py-2 rounded hover:bg-red-300"
                                        >
                                        <i data-lucide="eye" class="text-yellow-800"></i>
                                        </button>
                                    
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
   
                


       
        
         <!-- Image Modal -->

<div id="modalBox" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden transition-all duration-300">
  <div class="bg-white p-6 rounded-2xl shadow-2xl w-full max-w-5xl transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
    
    <!-- Header -->
    <div class="flex justify-between items-center mb-4 border-b pb-2">
      <h2 class="text-2xl font-bold text-gray-800">📸 Detail Parkir</h2>
      <button onclick="closeImageModal()" class="text-red-500 hover:text-red-700 text-3xl font-bold">&times;</button>
    </div>

    <!-- Image Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Gambar Masuk -->
      <div class="bg-gray-50 rounded-lg p-4 shadow-inner">
        <p class="font-semibold text-center mb-2 text-gray-700">🚘 Gambar Masuk</p>
        <img id="modalImageMasuk" class="max-h-64 mx-auto rounded-lg border hover:scale-105 transition-transform duration-300" src="" alt="Gambar Masuk">
        <p class="text-center mt-2 text-sm text-gray-600"><strong>Waktu:</strong> <span id="modalWaktuIn"></span></p>
      </div>

      <!-- Gambar Keluar -->
      <div class="bg-gray-50 rounded-lg p-4 shadow-inner">
        <p class="font-semibold text-center mb-2 text-gray-700">🚗  Gambar Keluar</p>
        <img id="modalImageKeluar" class="max-h-64 mx-auto rounded-lg border hover:scale-105 transition-transform duration-300" src="" alt="Gambar Keluar">
        <p class="text-center mt-2 text-sm text-gray-600"><strong>Waktu:</strong> <span id="modalWaktuOut"></span></p>
      </div>
    </div>

    <!-- Info Section -->
    <div class="mt-6 space-y-2 text-gray-700 text-sm">
      <p><strong>UID:</strong> <span id="modalUid" class="text-blue-700 font-medium"></span></p>
      <p><strong>Nama:</strong> <span id="modalName" class="text-blue-700 font-medium"></span></p>
      <p><strong>Status:</strong> 
        <span id="modalStatus" class="inline-block px-3 py-1 text-xs font-semibold rounded-full"></span>
      </p>
    </div>

  </div>
</div>



<script>
   
    let deleteUserId = null;

    function showImageModal(image_masuk, image_keluar, name, uid, _Status, waktu_masuk, waktu_keluar,) {
    const modal = document.getElementById("modalBox");
     const modalContent = document.getElementById("modalContent");
     const statusSpan = document.getElementById("modalStatus"); 
    rawBase64_masuk = 'data:image/jpeg;base64,' + image_masuk;
    rawBase64_keluar = 'data:image/jpeg;base64,' + image_keluar;


    // Asumsikan base64 sudah dalam format "data:image/jpeg;base64,...."
    document.getElementById("modalImageMasuk").src = rawBase64_masuk;
    document.getElementById("modalImageKeluar").src = rawBase64_keluar;
    document.getElementById("modalUid").innerText = uid;
    document.getElementById("modalName").innerText = name;
    document.getElementById("modalWaktuIn").innerText = waktu_masuk;
    document.getElementById("modalWaktuOut").innerText = waktu_keluar;
        // Update status
    statusSpan.className = "px-2 py-1 rounded text-xs font-semibold " +
        (_Status === '1' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800');
    statusSpan.innerText = _Status === '1' ? 'Success' : 'Menunggu';


      // Show modal
  modal.classList.remove("hidden");
  setTimeout(() => {
    modalContent.classList.remove("scale-95", "opacity-0");
    modalContent.classList.add("scale-100", "opacity-100");
  }, 50);
   
  }

  function closeImageModal() {
     const modal = document.getElementById("modalBox");
  const modalContent = document.getElementById("modalContent");

  modalContent.classList.add("scale-95", "opacity-0");
  modalContent.classList.remove("scale-100", "opacity-100");

  setTimeout(() => {
    modal.classList.add("hidden");
  }, 300); // Sesuai durasi transition
   
  }

  

   
    const ctx = document.getElementById('parkingChart').getContext('2d');
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
        const btn = document.getElementById('pdfBtn');
        btn.disabled = true;
        btn.classList.remove('bg-blue-600');
        btn.classList.add('bg-gray-400');

        // Tambahkan spinner ke dalam button
        btn.innerHTML = `
            <span class="spinner"></span>
            Exporting...
        `;

        const canvas1 = document.getElementById('parkingChart');
        const image1 = canvas1.toDataURL('image/png'); // Convert to Base64 PNG
        const canvas2 = document.getElementById('kendaraanChart');
        const image2= canvas2.toDataURL('image/png'); // Convert to Base64 PNG
        document.getElementById('chart_image_biaya').value = image1;
        document.getElementById('chart_image_kendaraan').value = image2;
        document.getElementById('pdfForm').submit();
    }

</script>


@endsection
