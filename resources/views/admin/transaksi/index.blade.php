@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Transaksi</h1>
        <a href="{{ route('admin/transaksi/create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Tambah Transaksi</a>
        
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
                    <th class="px-4 py-2 border">MemberID</th>
                    <th class="px-4 py-2 border">Jenis</th>
                    <th class="px-4 py-2 border">Jumlah</th>
                    <th class="px-4 py-2 border">CreatedDate</th>
                    <th class="px-4 py-2 border">CreatedBy</th>
                    <th class="px-4 py-2 border">LastUpdateBy</th>
                    <th class="px-4 py-2 border">LastUpdateDate</th>
                    <th class="px-4 py-2 border">CompanyCode</th>
                    <th class="px-4 py-2 border">_Status</th>
                    <th class="px-4 py-2 border">IsDeleted</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksis as $transaksi)
                    <tr>
                        <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border">{{ $transaksi->user_id }}</td>
                        <td class="px-4 py-2 border">{{ $transaksi->member_id }}</td>
                        <td class="px-4 py-2 border">{{ $transaksi->jenis }}</td>
                        <td class="px-4 py-2 border">Rp {{ number_format($transaksi->jumlah, 2, ',', '.') }}</td>
                        <td class="px-4 py-2 border">{{ $transaksi->CreatedDate }}</td>
                        <td class="px-4 py-2 border">{{ $transaksi->CreatedBy }}</td>
                        <td class="px-4 py-2 border">{{ $transaksi->LastUpdateBy }}</td>
                        <td class="px-4 py-2 border">{{ $transaksi->LastUpdateDate }}</td>
                        <td class="px-4 py-2 border">{{ $transaksi->CompanyCode }}</td>
                        <td class="px-4 py-2 border">{{ $transaksi->_Status }}</td>
                        <td class="px-4 py-2 border">{{ $transaksi->IsDeleted }}</td>
                        <td class="px-4 py-2 border">
                            <div class="flex justify-center-safe gap-4">
                                <div class="">

                                    <a href="" class="bg-cyan-600 px-4 py-2 rounded hover:bg-cyan-300">Edit</a>
                                </div>
                                <div class="">
                                    <form action="" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 px-4 py-2 rounded hover:bg-red-300">Hapus</button>
                                    </form>

                                </div>


                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $transaksis->links() }}
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

@endsection