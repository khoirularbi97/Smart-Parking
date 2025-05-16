@extends('layouts.app')

@section('title', 'Registrasi')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Registrasi</h1>
        <a href="{{ route('admin/member/create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Tambah Member Baru</a>
    </div>

    
    
    <div class="bg-white shadow rounded overflow-x-auto p-6">

        <form action="{{ route('admin.member') }}" method="GET" class="mb-4 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email..." class="border p-2 rounded w-1/3">
            <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Cari</button>
        </form>
        
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100">

                    <th class="px-4 py-2 border">No.</th>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Uid</th>
                    <th class="px-4 py-2 border">Saldo</th>
                    <th class="px-4 py-2 border">CreatedDate</th>
                    <th class="px-4 py-2 border">CreatedBy</th>
                    <th class="px-4 py-2 border">LastUpdateBy</th>
                    <th class="px-4 py-2 border">LastUpdateDate</th>
                    <th class="px-4 py-2 border">CompanyCode</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">IsDeleted</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border">{{ $user->name }}</td>
                        <td class="px-4 py-2 border">{{ $user->email }}</td>
                        <td class="px-4 py-2 border">{{ $user->uid }}</td>
                        <td class="px-4 py-2 border">{{ $user->saldo }}</td>
                        <td class="px-4 py-2 border">{{ $user->CreatedDate }}</td>
                        <td class="px-4 py-2 border">{{ $user->CreatedBy }}</td>
                        <td class="px-4 py-2 border">{{ $user->LastUpdateBy }}</td>
                        <td class="px-4 py-2 border">{{ $user->LastUpdateDate }}</td>
                        <td class="px-4 py-2 border">{{ $user->CompanyCode }}</td>
                        <td class="px-4 py-2 border">{{ $user->Status }}</td>
                        <td class="px-4 py-2 border">{{ $user->IsDeleted }}</td>
                        <td class="px-4 py-2 border">
                            <div class="flex justify-center-safe gap-4">
                                <div class="center">
                                    <a href="{{ route('admin.member.edit', $user->id) }}" class="bg-cyan-600 px-4 py-2 rounded hover:bg-cyan-300">Edit</a>
                                </div>
                                <div class="center">
                                    
                                 <button  onclick="showConfirmModal({{ $user->id }})" class="bg-red-600 px-4 py-2 rounded hover:bg-red-300">Hapus</button>
                                
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
            {{ $users->links() }}
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
    form.action = '{{ url("admin/member") }}/' + deleteUserId;
    form.submit();
}
</script>

@endsection