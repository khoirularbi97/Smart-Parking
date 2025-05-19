@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Transaksi</h1>
        
    </div>
    <div class="p-6 grid grid-cols-1 gap-4">


        <div class="bg-white shadow rounded overflow-x-auto p-6">
            <div class="justify-between items-center mb-6">
            <form action="" method="GET" class="mb-4 flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email..." class="border p-2 rounded w-1/3">
                <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Cari</button>
            </form>
            
            <a href="{{ route('admin/transaksi/create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Tambah Transaksi</a>
            </div>
            <div class="table-responsive">
            <table class="relative min-w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">No.</th>
                        <th class="px-4 py-2 border">Aksi</th>
                        <th class="px-4 py-2 border">UID</th>
                        <th class="px-4 py-2 border">Nama</th>
                        <th class="px-4 py-2 border">Jenis</th>
                        <th class="px-4 py-2 border">Jumlah</th>
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
                    @forelse ($transaksis as $transaksi)
                        <tr>
                            <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border">
                                <div class="flex justify-center-safe gap-4">
                                    <div class="">

                                    <button onclick="window.location.href='{{ route('admin.transaksi.edit', $transaksi->id) }}'" class="bg-cyan-600 px-4 py-2 rounded hover:bg-cyan-300">Edit</button>
                                    </div>
                                    <div class="">
                                            <button onclick="showConfirmModal({{ $transaksi->id }})" class="bg-red-600 px-4 py-2 rounded hover:bg-red-300">Hapus</button>
                                    

                                    </div>


                                </div>
                            </td>
                            <td class="px-4 py-2 border">{{ $transaksi->uid }}</td>
                            <td class="px-4 py-2 border">{{ $transaksi->nama }}</td>
                            <td class="px-4 py-2 border">{{ $transaksi->jenis }}</td>
                            <td class="px-4 py-2 border">Rp {{ number_format($transaksi->jumlah, 2, ',', '.') }}</td>
                            <td class="px-4 py-2 border">{{ $transaksi->CreatedDate }}</td>
                            <td class="px-4 py-2 border">{{ $transaksi->CreatedBy }}</td>
                            <td class="px-4 py-2 border">{{ $transaksi->LastUpdateBy }}</td>
                            <td class="px-4 py-2 border">{{ $transaksi->LastUpdateDate }}</td>
                            <td class="px-4 py-2 border">{{ $transaksi->CompanyCode }}</td>
                            <td class="px-4 py-2 border">{{ $transaksi->_Status }}</td>
                            <td class="px-4 py-2 border">{{ $transaksi->IsDeleted }}</td>
                            
                            
                        </tr>
                        @empty
                        <tr>
                            <td class="border text-center px-4 py-2" colspan="13">Not found</td>
                            
                        </tr>
                    
                @endforelse
                </tbody>
            </table>
            <div class="p-4">
                {{ $transaksis->links() }}
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
</script>


@endsection