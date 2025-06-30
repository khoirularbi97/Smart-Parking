@extends('layouts.app')

@section('title', 'Topup')

@section('content')
<x-page-header
    title=""
    :breadcrumbs="[
        ['label' => 'Home', 'url' => '/dashboard'],
        ['label' => 'Top-up', 'url' => '/topup/admin'],
        ['label' => 'Edit Topup Member']
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
                <h1 class="text-2xl text-center font-bold mb-6">Edit Topup Member</h1>
                <form method="POST" id="topup-form">
                    @csrf

                   <!-- Pilih User -->
                        <div class="mb-4">
                            <x-input-label for="users_id" :value="__('Pilih User')" />
                            <select id="users_id" type="text" required name="users_id" class="block mt-2 w-full border-gray-300 rounded-md shadow-sm">
                                <option class="mt-1 mb-1" >-- Pilih User --</option>
                                @foreach($users as $user)
                                    <option 
                                        value="{{ $user->users_id }}" 
                                        data-alamat="{{ $user->alamat }}" 
                                        data-nama="{{ $user->name }}"
                                        {{ $topup->users_id == $user->users_id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('users_id')" class="mt-2" />
                        </div>
                    <!-- Nama (readonly) -->
                    <div class="mb-4">
                        <x-input-label for="nama" :value="__('Nama')" />
                        <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" readonly />
                    </div>
                    <!-- Alamat(readonly) -->
                    <div class="mb-4">
                        <x-input-label for="uid" :value="__('Alamat')" />
                        <x-text-input id="alamat" class="block mt-1 w-full" type="text" name="alamat" readonly />
                    </div>

                    
                    <!-- Method (readonly) -->
                    <div class="mb-4">
                        <x-input-label for="method" :value="__('method')" />
                        <x-text-input id="method" class="block mt-1 w-full" type="text" name="method" readonly value="{{ old('method', $topup->method) }}" />
                    </div>
                    
                    <!-- Status (readonly) -->
                    <div class="mb-4">
                        <x-input-label for="status" :value="__('Status')" />
                        <x-text-input id="status" class="block mt-1 w-full" type="text" name="status" readonly value="{{ old('status', $topup->status) }}" />
                    </div>
                    
                   
                    <!-- Jumlah -->
                    <div class="mb-4">
                        <x-input-label for="amount" :value="__('Jumlah')" />
                        <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount"  required value="{{ old('amount', $topup->amount) }}" />
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
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
                    document.getElementById('alamat').value = selected.dataset.alamat || '';
                    document.getElementById('nama').value = selected.dataset.nama || '';
                  
                });
                </script>
                 @endpush
            </div>
        </div>
    </div>
</div>

@endsection