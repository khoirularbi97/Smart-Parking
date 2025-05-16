@extends('layouts.app')

@section('title', 'Parkir_masuk')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Parkir Masuk</h1>
        
        
    </div>

    
    
    <div class="bg-white shadow rounded overflow-x-auto p-6">

        <form action="" method="GET" class="mb-4 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email..." class="border p-2 rounded w-1/3">
            <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Cari</button>
        </form>
        
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">No.</th>
                    <th class="px-4 py-2 border">UserID</th>
               
                     <th class="px-4 py-2 border">CreatedDate</th>
                    <th class="px-4 py-2 border">CreatedBy</th>
                    <th class="px-4 py-2 border">LastUpdateBy</th>
                    <th class="px-4 py-2 border">LastUpdateDate</th>
                    <th class="px-4 py-2 border">CompanyCode</th>
                    <th class="px-4 py-2 border">IsDeleted</th>
                    <th class="px-4 py-2 border">Image</th>
                    <th class="px-4 py-2 border w-32">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($parkir_masuk as $masuk)
                    <tr>
                        <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border">{{ $masuk->uid }}</td>
                      
                        <td class="px-4 py-2 border">{{ $masuk->CreatedDate }}</td>
                        <td class="px-4 py-2 border">{{ $masuk->CreatedBy }}</td>
                        <td class="px-4 py-2 border">{{ $masuk->LastUpdateBy }}</td>
                        <td class="px-4 py-2 border">{{ $masuk->LastUpdateDate }}</td>
                        <td class="px-4 py-2 border">{{ $masuk->CompanyCode }}</td>
                        <td class="px-4 py-2 border">{{ $masuk->_Status }}</td>
                        <td class="px-4 py-2 border">
                         @if (Str::startsWith($masuk->image_base64, '/9j')) {{-- Cek awalan base64 (JPEG) --}}
                            <img src="data:image/jpeg;base64,{{ $masuk->image_base64 }}" alt="Gambar">
                        @else
                            <img src="{{ $masuk->image_path }}" alt="Gambar">
                        @endif
                        </td>
                        <td class="px-4 py-2 border ">
                            <div class="flex justify-center-safe gap-4">
                                <div class="mb-2">

                                    <a href="" class="bg-cyan-600 px-4 py-2 rounded hover:bg-cyan-300">Edit</a>
                                </div>
                                <div class="mb-2">
                                    
                                        <button onclick="showConfirmModal({{ $masuk->id }})" class="bg-red-600 px-4 py-2 rounded hover:bg-red-300">Hapus</button>
                                  

                                </div>


                            </div>
                        </td>
                        
                    </tr>
                @empty
                    <tr>
                        <td class="border text-center px-4 py-2" colspan="13">Not found</td>
                        
                    </tr>
                
            @endforelse
            </tbody>
        </table>
        <div class="p-4">
            {{ $parkir_masuk->links() }}
        </div>
        <form id="deleteForm"  class="hidden" method="POST">
                                        @csrf
                                        @method('DELETE')
                                          </form>
    
</div>
<x-popup-delete></x-popup-delete>
    
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
</script>
@endsection