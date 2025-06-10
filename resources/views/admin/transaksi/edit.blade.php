@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')

    <x-page-header 
        title="Update Transaksi"
        :breadcrumbs="[
            ['label' => 'Home', 'url' => '/transaksi'],
            ['label' => 'Update Transaksi']
        ]"
    />



<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl text-center font-bold mb-6"></h1>
               <form method="POST" action="{{ route('admin.transaksi.update', $transaksi->id) }}">
                   @csrf
                    @method('PUT') <!-- Penting! -->
    

                   <!-- Pilih User -->
                        <div class="mb-4">
                            <x-input-label for="users_id" :value="__('Pilih User')" />
                            <select id="users_id" type="text" required name="users_id" class="block mt-2 w-full border-gray-300 rounded-md shadow-sm" value="">
                            
                                <option class="mt-1 mb-1" >-- Pilih User --</option>
                                @foreach($users as $user)
                                    <option 
                                        value="{{ $user->users_id }}" 
                                        data-uid="{{ $user->uid }}" 
                                        data-nama="{{ $user->name }}"
                                        {{ $transaksi->users_id == $user->users_id ? 'selected' : '' }}>
                                        {{ $user->users_id }} - {{ $user->uid }} - {{ $user->name }}
                                    </option>

                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('users_id')" class="mt-2" />
                        </div>
                    <!-- UID (readonly) -->
                    <div class="mb-4">
                        <x-input-label for="uid" :value="__('UID')" />
                        <x-text-input id="uid" class="block mt-1 w-full" type="text" name="uid" value="{{ old('uid', $transaksi->uid) }}" readonly />

                    </div>

                    <!-- Nama (readonly) -->
                    <div class="mb-4">
                        <x-input-label for="nama" :value="__('Nama')" />
                        <x-text-input id="nama" class="block mt-1 w-full" type="text" value="{{ old('nama', $transaksi->nama) }}" name="nama" readonly />
                    </div>

                    <!-- Jenis-->
                    <div class="mb-4">
                        <label for="jenis" class="block text-sm font-medium text-gray-700">Pilih Jenis</label>
                        <select type="text" required name="jenis" id="jenis" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value = "">
                            <option disabled selected>-- Pilih Jenis --</option>
                                <option value="debit" {{ old('jenis', $transaksi->jenis) == 'debit' ? 'selected' : '' }}>Debit</option>
                                <option value="kredit" {{ old('jenis', $transaksi->jenis) == 'kredit' ? 'selected' : '' }}>Kredit</option>

                        </select>
                        <x-input-error :messages="$errors->get('jenis')" class="mt-2" />
                    </div>
                    <!-- Jumlah -->
                    <div class="mb-4">
                        <x-input-label for="jumlah" :value="__('Jumlah')" />
                        <x-text-input id="jumlah" class="block mt-1 w-full" type="number" name="jumlah" value="{{ old('jumlah', $transaksi->jumlah) }}"  />
                        <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <x-input-label for="Keterangan" :value="__('Keterangan')" />
                        <x-text-input id="keterangan" class="block mt-1 w-full text-box" type="text" name="keterangan"  required value="{{ old('keterangan', $transaksi->keterangan) }}" />
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