@extends('layouts.app')

@section('title', 'Parkir_masuk')

@section('content')
<x-page-header
    title=""
    :breadcrumbs="[
       ['label' => 'Home', 'url' => '/dashboard'],
        ['label' => 'Slot Parkir']
        
    ]"
/>
{{-- Slot Parkir --}}
<div class="container">
<div class="bg-white border-4 border-indigo-200 border-t-sky-500 rounded-xl shadow-xl p-6 mt-6">
    <h2 class="text-xl font-semibold mb-10 text-gray-700">Slot Parkir</h2>
    <div class="card shadow-sm mt-4">
    <div class="card-header bg-white">
        <div class="justify-between items-center">
    <button class="btn bg-sky-600 hover:bg-cyan-500 text-white" data-bs-toggle="modal" data-bs-target="#addSlotModal">
    + Tambah Slot Baru
    </button>
    </div>
    </div>
    <div class="card-body">
       
    
    

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @foreach($slots as $slot)
    <div class="flex flex-col items-center p-4 rounded-lg shadow-sm border 
        {{ $slot->is_available == 'tersedia' ? 'bg-green-50 border-green-300' : 'bg-red-50 border-red-300' }}">
        
        <div class="text-2xl font-bold">{{ $slot->name }}</div>

        <span class="mt-2 text-sm font-medium 
            {{ $slot->is_available == 'tersedia' ? 'text-green-600' : 'text-red-600' }}">
            {{ ucfirst($slot->is_available) }}
        </span>
        
        <button data-bs-toggle="modal" data-bs-target="#editSlotModal{{ $slot->id }}" class="btn bg-gray-100 p-1 rounded hover:bg-cyan-300">
            <i data-lucide="square-pen" class="text-cyan-800"></i>
        </button>
        <button onclick="showConfirmModal({{ $slot->id }})" class="bg-gray-100 p-1 rounded hover:bg-red-300"   title="Hapus Slot"><i data-lucide="trash-2" class="text-red-800"></i></button>

        <form  id="delete-form-{{ $slot->id }}" action="{{ route('admin.parkir_slot.destroy', $slot->id) }}" class="hidden" method="POST">
            @csrf
            @method('DELETE')
            </form>
                                    


        @if($slot->is_available == 'terisi')
            <span class="text-xs text-gray-500 mt-1">
                Nama: {{ $slot->created_at ?? 'Tidak diketahui' }}
            </span>
        @endif
    </div>

    <!-- Modal Edit Slot -->
    <div class="modal fade" id="editSlotModal{{ $slot->id }}" tabindex="-1" aria-labelledby="editSlotModalLabel{{ $slot->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('slot.update', $slot->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSlotModalLabel{{ $slot->id }}">Edit Slot {{ $slot->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="kode_slot_{{ $slot->id }}" class="form-label">Kode Slot</label>
                            <input type="text" class="form-control" id="kode_slot_{{ $slot->id }}" name="kode_slot" value="{{ $slot->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="status_{{ $slot->id }}" class="form-label">Status</label>
                            <select class="form-select" id="status_{{ $slot->id }}" name="status" required>
                                <option value="tersedia" {{ $slot->is_available == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="terisi" {{ $slot->is_available == 'terisi' ? 'selected' : '' }}>Terisi</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach

    </div>
</div>

<!-- Modal Tambah Slot -->
<div class="modal fade" id="addSlotModal" tabindex="-1" aria-labelledby="addSlotModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('slot.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addSlotModalLabel">Tambah Slot Parkir</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="kode_slot" class="form-label">Kode Slot</label>
            <input type="text" class="form-control" id="kode_slot" name="kode_slot" placeholder="Contoh: PRK03" required>
          </div>
          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
              <option value="tersedia">Tersedia</option>
              <option value="terisi">Terisi</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

</div>



@endsection