@extends('layouts.app')

@section('title', 'Registrasi')

@section('content')
<x-page-header
    title=""
    :breadcrumbs="[
        ['label' => 'Home', 'url' => '/dashboard'],
        ['label' => 'Registrasi']
     
    ]"/>
 
    <div class="p-1 grid grid-cols-1 gap-1">
        <div class="bg-white border-4 border-indigo-200 border-t-green-500 shadow-xl rounded-xl  p-6">
        <h1 class="text-2xl text-center font-bold mb-10">Registrasi</h1>
        <div class="justify-between items-center mb-6">
            <form action="{{ route('admin.member') }}" method="GET" class="mb-4 flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email..." class="border p-2 rounded w-1/3">
                <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Cari</button>
            </form>
        <a href="{{ route('admin/member/create') }}" class="bg-sky-600 hover:bg-cyan-500 text-white px-4 py-2 rounded">+Tambah Member Baru</a>
        <button onclick="exportPDF()" id="pdfBtn" type="button" class="flex bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded mt-2 ">
                    <i data-lucide="file-down"></i>pdf
                    </button>
        </div>
        <div class="table-responsive">
        <table class="min-w-full ">
            <thead>
                <tr class="bg-gray-100">

                    <th class="px-4 py-2 border">No.</th>
                    <th class="px-4 py-2 border">Aksi</th>
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
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td class="px-4 py-2 border">{{$users->firstItem() + $loop->index }}</td>
                        <td class="p-1 border">
                            <div class="flex justify-center-safe gap-1">
                                <div class="center">
                                    <button onclick="window.location='{{ route('admin.member.edit', $user->id) }}'" class="bg-gray-100 p-1 rounded hover:bg-cyan-300"><i data-lucide="square-pen" class="text-cyan-800"></i></button>
                                </div>
                                <div class="center">
                                    
                                                                     
                                  <button onclick="showConfirmModal({{ $user->id }})" class="bg-gray-100 p-1 rounded hover:bg-red-300"   title="Hapus Topup"><i data-lucide="trash-2" class="text-red-800"></i></button>
                                            
                                            <form  id="delete-form-{{ $user->id }}" action="{{ route('admin.member.destroy', $user->id) }}" class="hidden" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                </form>
                                    
                                 
                                
                                </div>
                                <div class="center">
                                    
                                 <button  onclick="" class="bg-gray-100 p-1 rounded hover:bg-yellow-300"><i data-lucide="eye" class="text-yellow-800"></i></button>
                                
                                </div>


                            </div>
                        </td>
                        <td class="px-4 py-2 border">{{ $user->name }}</td>
                        <td class="px-4 py-2 border">{{ $user->email }}</td>
                        <td class="px-4 py-2 border">{{ $user->uid }}</td>
                        <td class="px-4 py-2 border">Rp {{ number_format($user->saldo, 2, ',', '.') }}</td>
                        <td class="px-4 py-2 border w-auto">{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y H:i') }}</td>
                        <td class="px-4 py-2 border">{{ $user->CreatedBy }}</td>
                        <td class="px-4 py-2 border">{{ $user->LastUpdateBy }}</td>
                        <td class="px-4 py-2 border">{{ $user->LastUpdateDate }}</td>
                        <td class="px-4 py-2 border">{{ $user->CompanyCode }}</td>
                        <td class="px-4 py-2 border">{{ $user->Status }}</td>
                        <td class="px-4 py-2 border">{{ $user->IsDeleted }}</td>
                        
                    </tr>
                    @empty
                        <tr>
                            <td class="border text-center px-4 py-2" colspan="13">Not found</td>
                            
                        </tr>
                    
                @endforelse
            </tbody>
        </table>
        </div>
        <div class="p-4">
            {{ $users->appends(request()->query())->links() }}
        </div>
        
    </div>
    </div>
 
<script>
    
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
  } 
</script>

@endsection