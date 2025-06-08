@extends('layouts.app')

@section('title', 'Topup')

@section('content')
<x-page-header-topup
    title="Craete Topup Member"
    :breadcrumbs="[
        ['label' => 'Home', 'url' => '/topup/admin'],
        ['label' => 'Create Topup Member']
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
                <h1 class="text-2xl text-center font-bold mb-6"></h1>
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
                                        data-nama="{{ $user->name }}">
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('users_id')" class="mt-2" />
                        </div>
                    <!-- Alamat(readonly) -->
                    <div class="mb-4">
                        <x-input-label for="uid" :value="__('Alamat')" />
                        <x-text-input id="alamat" class="block mt-1 w-full" type="text" name="alamat" readonly />
                    </div>

                    <!-- Nama (readonly) -->
                    <div class="mb-4">
                        <x-input-label for="nama" :value="__('Nama')" />
                        <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" readonly />
                    </div>
                    
                   
                    <!-- Jumlah -->
                    <div class="mb-4">
                        <x-input-label for="amount" :value="__('Jumlah')" />
                        <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount"  required />
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
                
                document.getElementById('topup-form').addEventListener('submit', function (e) {
                    e.preventDefault();
                    fetch('{{ route("admin.topup.process") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        amount: document.querySelector('[name="amount"]').value,
                        users_id: document.querySelector('[name="users_id"]').value
                    })
                })
                .then(async response => {
                    const text = await response.text();
                    try {
                        const data = JSON.parse(text);
                        window.snap.pay(data.token, {
                            onSuccess: function(result) {
                                alert('Topup berhasil!');

                                window.location.reload();
                            },
                            onPending: function(result) {
                                alert('Menunggu pembayaran...');
                            },
                            onError: function(result) {
                                alert('Pembayaran gagal.');
                            }
                        });
                    } catch (e) {
                        console.error("Gagal parsing JSON: ", text);
                        alert("Terjadi kesalahan saat menghubungi server.");
                    }
                });
                });
                function openModal() {
                const overlay = document.getElementById('modalOverlay');
                const modal = document.getElementById('modalBox');

                overlay.classList.remove('hidden');

                // Pakai timeout agar animasi bisa berjalan setelah visible
                setTimeout(() => {
                    modal.classList.remove('scale-95', 'opacity-0');
                    modal.classList.add('scale-100', 'opacity-100');
                }, 10);
                }
                function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(angka);
                }

                function closeModal() {
                const overlay = document.getElementById('modalOverlay');
                const modal = document.getElementById('modalBox');

                modal.classList.remove('scale-100', 'opacity-100');
                modal.classList.add('scale-95', 'opacity-0');

                setTimeout(() => {
                    overlay.classList.add('hidden');
                }, 300); // waktu sesuai dengan duration-300
                }

                document.addEventListener('DOMContentLoaded', function () {
                    document.querySelectorAll('.btn-check-status').forEach(button => {
                        button.addEventListener('click', function () {
                            const orderId = this.getAttribute('data-order-id');
                            const statusElement = document.getElementById(`status-${orderId}`);

                            fetch(`/api/midtrans/status/${orderId}`, {
                                method: 'GET',
                                headers: {
                                    'Accept': 'application/json',
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log('status', data);
                                const statusText = data.status ?? 'Tidak ditemukan';
                                statusElement.textContent = statusText;
                                document.getElementById('modalOrderId').innerText = orderId;
                                document.getElementById('modalStatus').innerText = data.status ?? 'Tidak diketahui';
                                document.getElementById('modalTransactionTime').innerText = data.transaction_time ?? '-';
                                document.getElementById('modalPaymentType').innerText = data.payment_type ?? '-';
                                document.getElementById('modalAmount').textContent = formatRupiah(data.gross_amount || 0);
                
                                
                                openModal();

                                // // Optional: Tambahkan alert jika ingin notifikasi
                                // alert(`Status untuk Order ${orderId}: ${statusText}`);
                            })
                            .catch(error => {
                                console.error('Gagal mengambil status:', error);
                                alert('Gagal mengambil status transaksi');
                            });
                        });
                    });
                });





                </script>
                @endpush
            </div>
        </div>
    </div>
</div>

@endsection