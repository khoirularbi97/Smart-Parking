@extends('layouts.app')

@section('title', 'Parkir_masuk')

@section('content')
<x-page-header
    title=""
    :breadcrumbs="[
       ['label' => 'Home', 'url' => '/dashboard'],
        ['label' => 'Parkir masuk']
        
    ]"
/>
   
   

    <div class="p-1 grid grid-cols-1 gap-1">
    
    <div class="bg-white border-4 border-indigo-200 border-t-yellow-500 shadow-xl rounded-xl overflow-x-auto p-6">
        <h1 class="text-2xl text-center font-bold mb-10">Parkir Masuk</h1>

        <form action="" method="GET" class="mb-4 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." class="border p-2 rounded w-1/3">
            <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Cari</button>
        </form>
      <div class="overflow-x-auto w-full">
        <div class="table-responsive">
          <table class="min-w-full border-collapse text-sm text-left text-gray-700 border border-gray-200 bg-white shadow rounded-lg">
              <thead>
                  <tr class="bg-gray-100">
                      <th class="px-4 py-2 border">No.</th>
                      <th class="px-4 py-2 border ">Aksi</th>
                      <th class="px-4 py-2 border">UID</th>
                      <th class="px-4 py-2 border">Nama</th>
                 
                      <th class="px-4 py-2 border">Status</th>
                      <th class="px-4 py-2 border">Waktu Masuk</th>
                      <th class="px-4 py-2 border">Image</th>
                  </tr>
              </thead>
              <tbody>
                  @forelse ($parkir_masuk as $masuk)
                  <tr>
                      <td class="px-4 py-2 border">{{$parkir_masuk->firstItem() + $loop->index}}</td>
                      <td class="p-1 border">
                          <div class="flex justify-center-safe gap-3">
                              
                              <div class="center">
                                  
                                      <button onclick="showConfirmModal({{ $masuk->id }})" class="bg-gray-100 p-1 rounded hover:bg-red-300"
                                        title="Hapus Parkir masuk"><i data-lucide="trash-2" class="text-red-800"></i></button>

                                       <form  id="delete-form-{{ $masuk->id }}" action="{{ route('admin.parkir_masuk.destroy', $masuk->id) }}" class="hidden" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                </form>
                              
      
                              </div>
                              <div class="center">
                                    
                                    <button   onclick="showImageModal(
                                            '{{$masuk->image_base64 }}',
                                            '{{ $masuk->user->name }}',
                                            '{{ $masuk->uid }}',
                                            '{{ $masuk->status }}',
                                            '{{ \Carbon\Carbon::parse($masuk->waktu_masuk )->format('d M Y H:i') }}'
                                        )" class="bg-gray-100 p-1 rounded hover:bg-yellow-300"><i data-lucide="eye" class="text-yellow-800"></i></button>
                                    
                                 </div>
      
      
                          </div>
                      </td>
                      
                      <td class="px-4 py-2 border">{{ $masuk->uid }}</td>
                      <td class="px-4 py-2 border">{{ $masuk->user->name}}</td>
                        
                      <td class="px-4 py-2 border">
                            <span class="px-2 py-1 rounded text-xs font-semibold 
                                    {{ $masuk->status == 'aktif' ? 'bg-green-200 text-green-800' : 'bg-gray-200 text-gray-800' }}">
                                    {{ $masuk->status }}
                                </span></td>
                          <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($masuk->waktu_masuk)->format('d M Y H:i') }}</td>
                          
                          
                          <td class="px-4 py-2 border">
                           @if (Str::startsWith($masuk->image_base64, '/9j')) {{-- Cek awalan base64 (JPEG) --}}
                              <img src="data:image/jpeg;base64,{{ $masuk->image_base64 }}" alt="Gambar" class="h-10 w-10 rounded shadow" >
                          @else
                              <img src="{{ $masuk->image_path }}" alt="Gambar">
                          @endif
                           
                          </td>
                      </tr>
                  @empty
                      <tr>
                          <td class="border text-center px-4 py-2" colspan="13">Not found</td>
                          
                      </tr>
                  
              @endforelse
              </tbody>
          </table>
        </div>
      </div>  
      <div class="mt-4">
          {{ $parkir_masuk->links() }}
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
    <div class="grid grid-cols-1 md:grid-cols-1">
      <!-- Gambar Masuk -->
      <div class="bg-gray-50 rounded-lg p-4 shadow-inner">
        <p class="font-semibold text-center mb-2 text-gray-700">🚘 Gambar Masuk</p>
        <img id="modalImageMasuk" class="max-h-70 mx-auto rounded-lg border hover:scale-105 transition-transform duration-300" src="" alt="Gambar Masuk">
        <p class="text-center mt-2 text-sm text-gray-600"><strong>Waktu:</strong> <span id="modalWaktuIn"></span></p>
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


    function showImageModal(image_base64, name, uid, status, waktu_masuk,) {
            const modal = document.getElementById("modalBox");
            const modalContent = document.getElementById("modalContent");
            const statusSpan = document.getElementById("modalStatus"); 
            rawBase64_masuk = 'data:image/jpeg;base64,' + image_base64;
           


            // Asumsikan base64 sudah dalam format "data:image/jpeg;base64,...."
            document.getElementById("modalImageMasuk").src = rawBase64_masuk;
            document.getElementById("modalUid").innerText = uid;
            document.getElementById("modalName").innerText = name;
            document.getElementById("modalWaktuIn").innerText = waktu_masuk;
            
                // Update status
            statusSpan.className = "px-2 py-1 rounded text-xs font-semibold " +
                (status === '1' ? 'bg-green-200 text-green-800' : 'bg-gray-200 text-gray-800');
            statusSpan.innerText = status === '1' ? 'Aktif' : 'Selesai';


            // Show modal
        modal.classList.remove("hidden");
        setTimeout(() => {
            modalContent.classList.remove("scale-95", "opacity-0");
            modalContent.classList.add("scale-100", "opacity-100");
        }, 50);
        
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
    function closeImageModal() {
     const modal = document.getElementById("modalBox");
        const modalContent = document.getElementById("modalContent");

        modalContent.classList.add("scale-95", "opacity-0");
        modalContent.classList.remove("scale-100", "opacity-100");
         setTimeout(() => {
            modal.classList.add("hidden");
        }, 300); // Sesuai durasi transition
    }

    // function showImageModal(src) {
    //     document.getElementById('modalImage').src = src;
    //     document.getElementById('imageModal').classList.remove('hidden');
    //     const modal = document.getElementById('modalBox');
    //     modal.classList.add('scale-100', 'opacity-100');

    // }

    // function closeImageModal() {
    //     document.getElementById('imageModal').classList.add('hidden');
    //     const modal = document.getElementById('modalBox');

    //         modal.classList.remove('scale-100', 'opacity-100');
    //         modal.classList.add('scale-95', 'opacity-0');
    // }

    // Tutup modal jika klik di luar gambar
    document.getElementById('imageModal').addEventListener('click', function (e) {
        if (e.target.id === 'imageModal') {
            closeImageModal();
            
        }
         

    });


</script>
@endsection