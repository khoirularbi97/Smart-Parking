@extends('layouts.app')

@section('title', 'Registrasi')

@section('content')
@csrf
@if(isset($user))
    @method('PUT')
@endif
<h2 class="text-2xl font-bold">Update Member</h2>

<div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
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
                        <x-input-label for="name" :value="__('UID')" />
                        <x-text-input id="uid" class="block mt-1 w-full" type="text" name="uid"  value=" {{ old('uid', $user->uid) }}" required/>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
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
            </div>
        </div>
    </div>
</div>



@endsection