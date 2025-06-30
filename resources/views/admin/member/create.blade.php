@extends('layouts.app')

@section('title', 'Registrasi')

@section('content')
<x-page-header
    title=""
    :breadcrumbs="[
        ['label' => 'Home', 'url' => '/dashboard'],
        ['label' => 'Registrasi', 'url' => '/member'],
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
                        <span class="text-red-500">*</span>
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <span class="text-red-500">*</span>
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password (dengan visibility toggle) -->
                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <span class="text-red-500">*</span>
                        <div class="relative">
                            <x-text-input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required />
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-2 flex items-center text-sm text-gray-600">
                                👁️
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- UID -->
                    <div class="mb-4">
                        <x-input-label for="uid" :value="__('UID')" />
                        
                        <x-text-input id="uid" class="block mt-1 w-full bg-gray-100" type="text" name="uid" readonly />
                        <x-input-error :messages="$errors->get('uid')" class="mt-2" />
                    </div>

                    <!-- No Telp -->
                    <div class="mb-4">
                        <x-input-label for="telepon" :value="__('Telepon')" />
                        <x-text-input id="telepon" class="block mt-1 w-full" type="text" name="telepon" />
                        <x-input-error :messages="$errors->get('telepon')" class="mt-2" />
                    </div>

                    <!-- Alamat -->
                    <div class="mb-4">
                        <x-input-label for="alamat" :value="__('Alamat')" />
                        <x-text-input id="alamat" class="block mt-1 w-full" type="text" name="alamat" />
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>

                    <!-- Saldo -->
                    <div class="mb-4">
                        <x-input-label for="role" :value="__('Saldo')" />
                        <select id="saldo" name="saldo" class="w-full border p-2 rounded">
                            <option selected>0</option>
                            <option value="10000">10.000</option>
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

                @push('scripts')
                <script>
                 //Password Toggle Script 
                function togglePassword() {
                    const input = document.getElementById('password');
                    input.type = input.type === 'password' ? 'text' : 'password';
                }
                 const ws = new WebSocket("wss://scurebot.cloud/ws/"); // ganti jika ws lokal: ws://localhost:5000

                    ws.onopen = () => {
                        console.log("✅ WebSocket frontend terhubung.");
                    };

                  ws.onmessage = (event) => {
                    console.log("📨 Pesan masuk:", event.data);

                    try {
                        const data = JSON.parse(event.data);

                        if (data.type === "uid_scanned" && data.uid) {
                            const inputUID = document.getElementById("uid");
                            if (inputUID) {
                                inputUID.value = data.uid;
                                console.log("✅ UID dimasukkan:", data.uid);
                            } else {
                                console.warn("⚠️ Input UID tidak ditemukan.");
                            }
                        } else {
                            console.warn("⚠️ Format data tidak dikenali:", data);
                        }
                    } catch (e) {
                        console.error("❌ Gagal parsing JSON:", e, event.data);
                    }
                };


                    ws.onerror = (e) => console.error("❌ WebSocket error:", e);

                </script>
                @endpush
            </div>
        </div>
    </div>
</div>

@endsection