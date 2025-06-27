@extends('layouts.app')

@section('title', 'Registrasi')

@section('content')
<x-page-header
    title="Update Member"
    :breadcrumbs="[
        ['label' => 'Home', 'url' => '/member'],
        ['label' => 'Update Member']
    ]"
/>

@csrf
@if(isset($user))
    @method('PUT')
@endif

<div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-4 ">
    <div class="py-1">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl text-center font-bold mb-6"></h1>
                <form method="POST" action="{{ route('admin.member.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                        
                    <!-- Nama -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nama')" />
                        <x-text-input id="name" class="block mt-1 w-full" value="{{ old('name', $user->name) }}" required  type="text" name="name" autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"  value="{{ old('email', $user->email) }}" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" value="{{ old('password', $user->password) }}"/>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- UID -->
                    <div class="mb-4">
                        <x-input-label for="uid" :value="__('UID')" />
                        <x-text-input id="uid" class="block mt-1 w-full bg-gray-100" type="text" name="uid"  value=" {{ old('uid', $user->uid) }}" required/>
                        <x-input-error :messages="$errors->get('uid')" class="mt-2" />
                    </div>

                    <!-- Saldo -->
                    <div class="mb-4">
                        <x-input-label for="saldo" :value="__('Saldo')" />
                        <x-text-input id="saldo" class="block mt-1 w-full" type="text" name="saldo"  value=" {{ old('saldo', $user->saldo) }}" required/>
                        <x-input-error :messages="$errors->get('saldo')" class="mt-2" />
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
                 const ws = new WebSocket("ws://localhost:5000"); // ganti jika ws lokal: ws://localhost:5000

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