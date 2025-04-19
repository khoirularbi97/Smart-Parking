@extends('layouts.app')

@section('title', 'Registrasi')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Registrasi</h1>
        <a href="" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Tambah Pengguna</a>
    </div>

    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Role</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($member as $user)
                    <tr>
                        <td class="px-4 py-2 border">{{ $user->nama }}</td>
                        <td class="px-4 py-2 border">{{ $user->UID }}</td>
                        <td class="px-4 py-2 border"></td>
                        <td class="px-4 py-2 border space-x-2">
                            <a href="" class="text-blue-600 hover:underline">Edit</a>
                            <form action="" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Yakin hapus?')" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection