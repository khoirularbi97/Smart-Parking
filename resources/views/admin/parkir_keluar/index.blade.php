@extends('layouts.app')

@section('title', 'Parkir_masuk')

@section('content')
<x-page-header2
    title=""
    :breadcrumbs="[
        ['label' => 'Home', 'url' => '/transaksi'],
        
    ]"
/>
   
   

    <div class="p-1 grid grid-cols-1 gap-1">
    
    <div class="bg-white border-4 border-indigo-200 border-t-red-500 shadow-xl rounded-xl overflow-x-auto p-6">
        <h1 class="text-2xl text-center font-bold mb-10">Parkir Keluar</h1>

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
                 
                 
                      <th class="px-4 py-2 border">Status pembayaran</th>
                      <th class="px-4 py-2 border">Waktu keluar</th>
                      <th class="px-4 py-2 border">Image</th>
                      <th class="px-4 py-2 border">biaya</th>
                  </tr>
              </thead>
              <tbody>
                  @forelse ($parkir_keluar as $keluar)
                  <tr>
                      <td class="px-4 py-2 border">{{$parkir_keluar->firstItem() + $loop->index}}</td>
                      <td class="p-1 border ">
                          <div class="flex justify-center-safe gap-1">
                              <div class="center">
      
                                  <button onclick="" class="bg-gray-100 p-1 rounded hover:bg-cyan-300"><i data-lucide="square-pen" class="text-cyan-800"></i></button>
                              </div>
                              <div class="center">
                                  
                                      <button onclick="showConfirmModal({{ $keluar->id }})" class="bg-gray-100 p-1 rounded hover:bg-red-300"><i data-lucide="trash-2" class="text-red-800"></i></button>
                              
      
                              </div>
                              <div class="center">
                                    
                                    <button  onclick="showImageModal(this.src)" class="bg-gray-100 p-1 rounded hover:bg-yellow-300"><i data-lucide="eye" class="text-yellow-800"></i></button>
                                    
                                    </div>
      
      
                          </div>
                      </td>
                      
                      <td class="px-4 py-2 border">{{ $keluar->uid }}</td>
                      <td class="px-4 py-2 border">{{ $keluar->user->name }}</td>
                        
                      <td class="px-4 py-2 border">
                            <span class="px-2 py-1 rounded text-xs font-semibold 
                                    {{ $keluar->status_pembayaran == 'lunas' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                    {{ $keluar->status_pembayaran }}
                                </span></td>
                          <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($keluar->waktu_keluar)->format('d M Y H:i') }}</td>
                          
                          
                          <td class="px-4 py-2 border">
                           @if (Str::startsWith($keluar->image_base64, '/9j')) {{-- Cek awalan base64 (JPEG) --}}
                              <img src="data:image/jpeg;base64,{{ $keluar->image_base64 }}" alt="Gambar" class="h-10 w-10 cursor-pointer rounded shadow" onclick="showImageModal(this.src)">
                          @else
                              <img src="{{ $keluar->image_path }}" alt="Gambar">
                          @endif
                           
                          </td>
                          <td class="px-4 py-2 border">Rp {{ number_format($keluar->biaya, 2, ',', '.') }}</td>
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
          {{ $parkir_keluar->links() }}
        </div>
    </div>  
        <form id="deleteForm"  class="hidden" method="POST">
                                        @csrf
                                        @method('DELETE')
                                          </form>
    
</div>
<x-popup-delete></x-popup-delete>
<!-- Image Modal -->

<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
     <!-- Modal box -->
  <div id="modalBox" class="bg-white p-6 rounded-xl shadow-lg transform scale-95 opacity-0 transition duration-300 ease-out w-full max-w-md">
    <h2 class="text-xl font-semibold mb-4">Detail PFoto</h2>
    <img id="modalImage" src="" class="max-w-full max-h-[100vh] rounded-lg border-4 border-white">
    <p><strong>UID:</strong> <span id="modalOrderId">{{ $keluar->uid }}</span></p>
    <p><strong>Status:</strong> <span id="modalStatus">{{ $keluar->status_pembayaran }}</span></p>
    <p><strong>Waktu:</strong> <span id="modalTransactionTime">
                          <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($keluar->waktu_keluar)->format('d M Y H:i') }}</span></p>
    <button onclick="closeImageModal()" class="mt-4 bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">Tutup</button>
  </div>
    <span class="absolute top-4 right-6 text-white text-3xl cursor-pointer" onclick="closeImageModal()">&times;</span>
    
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
    form.action = '{{ url("admin/parkir_masuk") }}/' + deleteUserId;
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


</script>
@endsection