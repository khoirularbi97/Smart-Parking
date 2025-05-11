@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
@csrf
@if(isset($user))
    @method('PUT')
@endif
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Transaksi</h1>

</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('store.transaksi') }}">
                    @csrf

                    <!-- Nama -->
                    <div class="mb-4">
                        <x-input-label for="userid" :value="__('UserID')" />
                        <x-text-input id="userid" class="block mt-1 w-full" type="text" name="userid" required autofocus />
                        <x-input-error :messages="$errors->get('userid')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <x-input-label for="memberid" :value="__('MemberID')" />
                        <x-text-input id="memberid" class="block mt-1 w-full" type="text" name="memberid"  required />
                        <x-input-error :messages="$errors->get('memberid')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <x-input-label for="jenis" :value="__('Jenis')" />
                        <x-text-input id="jenis" class="block mt-1 w-full" type="text" name="jenis" required />
                        <x-input-error :messages="$errors->get('jenis')" class="mt-2" />
                    </div>

                    <!-- UID -->
                    <div class="mb-4">
                        <x-input-label for="jumlah" :value="__('Jumlah')" />
                        <x-text-input id="jumlah" class="block mt-1 w-full" type="text" name="jumlah"  required />
                        <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end">
                        <x-primary-button class="ml-4">
                            {{ __('Simpan') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection