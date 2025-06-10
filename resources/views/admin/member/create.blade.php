@extends('layouts.app')

@section('title', 'Registrasi')

@section('content')
<x-page-header2
    title=""
    :breadcrumbs="[
        ['label' => 'Home', 'url' => '/member'],
        ['label' => 'Tambah Member']
    ]"
/>
@csrf
@if(isset($user))
    @method('PUT')
@endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-1">
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl text-center font-bold mb-6">Tambah member</h1>
                <form method="POST" action="{{ route('store') }}">
                    @csrf

                    <!-- Nama -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nama')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"  required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- UID -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('UID')" />
                        <x-text-input id="uid" class="block mt-1 w-full" type="text" name="uid"  required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Saldo -->
                    <div class="mb-4">
                        <x-input-label for="role" :value="__('Saldo')" />
                        <select id="saldo" name="saldo"class="w-full border p-2 rounded">
                            <option selected>0</option>
                            <option value="1000">10.000</option>
                            <option value="30000">30.000</option>
                            <option value="50000">50.000</option>
                           
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
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