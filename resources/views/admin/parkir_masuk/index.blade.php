@extends('layouts.app')

@section('title', 'Parkir_masuk')

@section('content')
<x-page-header2
    title="Parkir Masuk"
    :breadcrumbs="[
        ['label' => 'Home', 'url' => '/transaksi'],
        
    ]"
/>
   
   

    <div class="p-6 grid grid-cols-1 gap-4">
    
    <div class="bg-white shadow rounded overflow-x-auto p-6">

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
                      <th class="px-4 py-2 border">UserID</th>
                 
                      <th class="px-4 py-2 border">Status</th>
                      <th class="px-4 py-2 border">CreatedDate</th>
                      <th class="px-4 py-2 border">CreatedBy</th>
                      <th class="px-4 py-2 border">LastUpdateBy</th>
                      <th class="px-4 py-2 border">LastUpdateDate</th>
                      <th class="px-4 py-2 border">CompanyCode</th>
                      <th class="px-4 py-2 border">IsDeleted</th>
                      <th class="px-4 py-2 border">Image</th>
                  </tr>
              </thead>
              <tbody>
                  @forelse ($parkir_masuk as $masuk)
                  <tr>
                      <td class="px-4 py-2 border">{{$parkir_masuk->firstItem() + $loop->index}}</td>
                      <td class="p-1 border ">
                          <div class="flex justify-center-safe gap-1">
                              <div class="center">
      
                                  <button onclick="" class="bg-gray-100 p-1 rounded hover:bg-cyan-300"><i data-lucide="square-pen"></i></button>
                              </div>
                              <div class="center">
                                  
                                      <button onclick="showConfirmModal({{ $masuk->id }})" class="bg-gray-100 p-1 rounded hover:bg-red-300"><i data-lucide="trash-2"></i></button>
                              
      
                              </div>
                              <div class="center">
                                    
                                    <button  onclick="" class="bg-gray-100 p-1 rounded hover:bg-yellow-300"><i data-lucide="printer"></i></button>
                                    
                                    </div>
      
      
                          </div>
                      </td>
                      
                      <td class="px-4 py-2 border">{{ $masuk->uid }}</td>
                        
                      <td class="px-4 py-2 border">
                            <span class="px-2 py-1 rounded text-xs font-semibold 
                                    {{ $masuk->status == 'aktif' ? 'bg-green-200 text-green-800' : 'bg-green-200 text-green-800' }}">
                                    {{ $masuk->status }}
                                </span></td>
                          <td class="px-4 py-2 border">{{ $masuk->CreatedDate}}</td>
                          <td class="px-4 py-2 border">{{ $masuk->CreatedBy }}</td>
                          <td class="px-4 py-2 border">{{ $masuk->LastUpdateBy }}</td>
                          <td class="px-4 py-2 border">{{ $masuk->LastUpdateDate }}</td>
                          <td class="px-4 py-2 border">{{ $masuk->CompanyCode }}</td>
                          <td class="px-4 py-2 border">{{ $masuk->IsDeleted }}</td>
                          <td class="px-4 py-2 border">
                           @if (Str::startsWith($masuk->image_base64, '/9j')) {{-- Cek awalan base64 (JPEG) --}}
                              <img src="data:image/jpeg;base64,{{ $masuk->image_base64 }}" alt="Gambar" class="h-auto w-auto cursor-pointer rounded shadow" onclick="showImageModal(this.src)">
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
        <form id="deleteForm"  class="hidden" method="POST">
                                        @csrf
                                        @method('DELETE')
                                          </form>
    
</div>
<x-popup-delete></x-popup-delete>
<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-75 flex items-center justify-center">
    <span class="absolute top-4 right-6 text-white text-3xl cursor-pointer" onclick="closeImageModal()">&times;</span>
    <img id="modalImage" src="" class="max-w-full max-h-[90vh] rounded-lg border-4 border-white">
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

    function showImageModal(src) {
        document.getElementById('modalImage').src = src;
        document.getElementById('imageModal').classList.remove('hidden');
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
    }

    // Tutup modal jika klik di luar gambar
    document.getElementById('imageModal').addEventListener('click', function (e) {
        if (e.target.id === 'imageModal') {
            closeImageModal();
        }
    });


</script>
@endsection