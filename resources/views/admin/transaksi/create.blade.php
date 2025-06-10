@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<x-page-header2
    title=""
    :breadcrumbs="[
        ['label' => 'Home', 'url' => '/transaksi'],
        ['label' => 'Tambah Transaksi']
    ]"
/>
@csrf
@if(isset($user))
    @method('PUT')
@endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl text-center font-bold mb-6">Tambah Transaksi</h1>
                <form method="POST" action="{{ route('store.transaksi') }}">
                    @csrf

                   <!-- Pilih User -->
                        <div class="mb-4">
                            <x-input-label for="users_id" :value="__('Pilih User')" />
                            <select id="users_id" type="text" required name="users_id" class="block mt-2 w-full border-gray-300 rounded-md shadow-sm">
                                <option class="mt-1 mb-1" >-- Pilih User --</option>
                                @foreach($users as $user)
                                    <option 
                                        value="{{ $user->users_id }}" 
                                        data-uid="{{ $user->uid }}" 
                                        data-nama="{{ $user->name }}">
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('users_id')" class="mt-2" />
                        </div>
                    <!-- UID (readonly) -->
                    <div class="mb-4">
                        <x-input-label for="uid" :value="__('UID')" />
                        <x-text-input id="uid" class="block mt-1 w-full bg-gray-100" type="text" name="uid" readonly />
                    </div>

                    <!-- Nama (readonly) -->
                    <div class="mb-4">
                        <x-input-label for="nama" :value="__('Nama')" />
                        <x-text-input id="nama" class="block mt-1 w-full bg-gray-100" type="text" name="nama" readonly />
                    </div>

                    <!-- Jenis-->
                    <div class="mb-4">
                        <label for="jenis" class="block text-sm font-medium text-gray-700">Pilih Jenis</label>
                        <select type="text" required name="jenis" id="jenis" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="debit">Debit</option>
                            <option value="kredit">Kredit</option>
                        </select>
                        <x-input-error :messages="$errors->get('jenis')" class="mt-2" />
                    </div>
                    <!-- Jumlah -->
                    <div class="mb-4">
                        <x-input-label for="jumlah" :value="__('Jumlah')" />
                        <x-text-input id="jumlah" class="block mt-1 w-full" type="number" name="jumlah"  required />
                        <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                    </div>
                    <!-- Keterangan -->
                    <div class="mb-4">
                        <x-input-label for="Keterangan" :value="__('Keterangan')" />
                        <x-text-input id="keterangan" class="block mt-1 w-full text-box" type="text" name="keterangan"  required />
                        <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end">
                        <x-primary-button class="ml-4">
                            {{ __('Simpan') }}
                        </x-primary-button>
                    </div>
                </form>
                @push('scripts')
                <script>
                document.getElementById('users_id').addEventListener('change', function () {
                    let selected = this.options[this.selectedIndex];
                    document.getElementById('uid').value = selected.dataset.uid || '';
                    document.getElementById('nama').value = selected.dataset.nama || '';
                });
                </script>
                @endpush
            </div>
        </div>
    </div>
</div>

@endsection