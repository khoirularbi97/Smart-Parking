@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<x-page-header2
    title="Top Up"
    :breadcrumbs="[
        ['label' => 'Home', 'url' => '/topup_member'],
        
    ]"
/>

    <div class="p-6 grid grid-cols-1 gap-4">


        <div class="bg-white shadow rounded overflow-x-auto p-6">
            <div class="justify-between items-center mb-6">
            <form action="" method="GET" class="mb-4 flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email..." class="border p-2 rounded w-1/3">
                <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Cari</button>
            </form>
            
            <a href="{{ route('admin/transaksi/create') }}" class="bg-sky-600 hover:bg-cyan-500 text-white px-4 py-2 rounded">Top Up Member</a>
            </div>
            <div class="table-responsive">
            <table class="relative min-w-full rounded-lg shadow">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">No.</th>
                        <th class="px-4 py-2 border">Aksi</th>
                        <th class="px-4 py-2 border">Nama</th>
                        <th class="px-4 py-2 border">Order ID</th>
                        <th class="px-4 py-2 border">Type</th>
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
                    @forelse ($topup as $topups)
                        <tr>
                            <td class="px-4 py-2 border">{{$topup->firstItem() + $loop->index }}</td>
                            <td class="p-1 border">
                                <div class="flex justify-center-safe gap-1 p-1">
                                    <div class="center">

                                    <button onclick="window.location.href='{{ route('admin.transaksi.edit', $topups->id) }}'" class="bg-gray-100 p-1 rounded hover:bg-cyan-300"><i data-lucide="square-pen"></i></button>
                                    </div>
                                    <div class="center">
                                            <button onclick="showConfirmModal({{ $topups->id }})" class="bg-gray-100 p-1 rounded hover:bg-red-300"><i data-lucide="trash-2"></i></button>
                                    

                                    </div>
                                    <div class="center">
                                    
                                    <button  onclick="" class="bg-gray-100 p-1 rounded hover:bg-yellow-300"><i data-lucide="printer"></i></button>
                                    
                                    </div>



                                </div>
                            </td>
                            <td class="px-4 py-2 border">{{ $topups->name }}</td>
                            <td class="px-4 py-2 border">{{ $topups->order_id }}</td>
                            <td class="px-4 py-2 border">{{ $topups->method }}</td>
                            <td class="px-4 py-2 border">{{ $topups->created_at }}</td>
                            <td class="px-4 py-2 border">{{ $topups->CreatedBy }}</td>
                            <td class="px-4 py-2 border">{{ $topups->LastUpdateBy }}</td>
                            <td class="px-4 py-2 border">{{ $topups->LastUpdateDate }}</td>
                            <td class="px-4 py-2 border">{{ $topups->CompanyCode }}</td>
                            <td class="px-4 py-2 border">
                                <span class="px-2 py-1 rounded text-xs font-semibold 
                                    @if($topups->status == 'success') 
                                        bg-green-200 text-green-800 
                                    @elseif($topups->status == 'pending') 
                                        bg-yellow-200 text-yellow-800 
                                    @else 
                                        bg-red-200 text-red-800 
                                    @endif">
                                    {{ ucfirst($topups->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 border">{{ $topups->IsDeleted }}</td>
                            <td class="px-4 py-2 border">Rp {{ number_format($topups->amount, 2, ',', '.') }}</td>
                            
                            
                        </tr>
                        @empty
                        <tr>
                            <td class="border text-center px-4 py-2" colspan="13">Not found</td>
                            
                        </tr>
                    
                @endforelse
                </tbody>
            </table>
            <div class="p-4">
                {{ $topup->links() }}
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