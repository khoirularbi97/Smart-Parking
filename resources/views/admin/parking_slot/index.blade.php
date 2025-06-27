@extends('layouts.app')

@section('title', 'Parkir_masuk')

@section('content')
<x-page-header2
    title=""
    :breadcrumbs="[
        ['label' => 'Home', 'url' => '/slot parkir'],
        
    ]"
/>
{{-- Slot Parkir --}}
<div class="bg-white rounded-xl shadow-md p-6 mt-6">
    <h2 class="text-xl font-semibold mb-4 text-gray-700">Tampilan Slot Parkir</h2>
    <div class="justify-between items-center mb-8">
    <a href="" class="bg-sky-600 hover:bg-cyan-500 text-white px-4 py-2 rounded">+Tambah Slot Baru</a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @foreach($slots as $slot)
            <div class="flex flex-col items-center p-4 rounded-lg shadow-sm border 
                {{ $slot->is_available == 'tersedia' ? 'bg-green-50 border-green-300' : 'bg-red-50 border-red-300' }}">
                
                <div class="text-2xl font-bold">
                    {{ $slot->name }}
                </div>

                <span class="mt-2 text-sm font-medium 
                    {{ $slot->is_available == 'tersedia' ? 'text-green-600' : 'text-red-600' }}">
                    {{ ucfirst($slot->is_available) }}
                </span>

                @if($slot->is_available == 'terisi')
                    <span class="text-xs text-gray-500 mt-1">
                        Nama: {{ $slot->created_at ?? 'Tidak diketahui' }}
                    </span>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection