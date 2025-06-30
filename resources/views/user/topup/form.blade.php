@extends('layouts.user')

@section('content')
<!-- Header -->
    <div class="flex items-center  bg-gradient-to-r from-pink-400 to-purple-500 rounded-2xl shadow-xl p-6 mb-6">
     
      <h1 class="text-white font-semibold text-lg">Topup Saldo</h1>
    </div>
  <!-- Content -->
  <main class="bg-gradient-to-br from-purple-200 to-indigo-200 flex-1 flex  items-center justify-center px-4 mb-6">
    <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md">
      <h2 class="text-xl font-bold text-gray-800 mb-4">Isi Saldo</h2>
      <form id="topup-form">
        @csrf
      <label class="block mb-2 text-sm text-gray-600">Masukkan jumlah topup</label>
      <input type="text" name="amount" id="amount" placeholder="Contoh: 10000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400 focus:outline-none mb-4" required />
      <button class="w-full bg-purple-500 hover:bg-purple-600 text-white py-2 rounded-lg transition duration-300 shadow-md" type="submit">Topup</button>
      </form>
    </div>
    
</main>
<div class="space-y-5 mb-24">
    @foreach ($histories as $history)
    <div class="bg-white rounded-2xl shadow-lg p-4">
        <div class="flex items-center justify-between mb-2">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-400 to-pink-400"><i data-lucide="{{ $history->method =='credit' ? 'credit-card' : 'wallet-minimal'  }} " class="w-8 h-8 p-1"></i></div>
                <div>
                    <p class="font-bold text-sm"><span class=" @if($history->status == 'success') 
                                        text-green-500 
                                    @elseif($history->status == 'pending') 
                                        text-yellow-500 
                                    @else 
                                        text-red-500 
                                    @endif " id="status-{{ $history->order_id }}">{{ $history->status ?? 'Nama Tidak Diketahui' }} </span></p>
                    <p class="text-xs text-gray-500">{{ $history->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
            <div class="text-right text-purple-700 font-semibold">
               Rp {{ number_format($history->amount, 0, ',', '.') }}
            </div>
        </div>
        <div class="flex items-center gap-2 justify-between">
            <p class="text-xs mt-2 text-black-500">Riwayat topup</p>
            
            <button  onclick="window.location.href='{{ route('invoice.user.show', $history->order_id) }}'" class="bg-gray-100 p-1 rounded hover:bg-yellow-300"><i data-lucide="printer" class="text-purple-800"></i></button>
            <button class="btn-check-status bg-pink-400 hover:bg-purple-400 text-white p-2 rounded-lg transition duration-300 shadow-md" data-order-id="{{ $history->order_id }}">
                Detail
                    </button>
        </div>
                {{-- <button 
                class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600 cek-status"
                data-id="{{ $history->id }}" 
                data-order-id="{{ $history->order_id }}">
                Detail
                </button> --}}

    </div>
    @endforeach
    </div>

 
        {{-- <div class="max-w-md mx-auto p-4">
            <h2 class="text-xl font-bold mb-4">Topup Saldo</h2>
            <form id="topup-form">
                @csrf
                <input type="number" name="amount" placeholder="Masukkan jumlah topup" required class="w-full border p-2 rounded mb-4" />

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Topup</button>
            </form>
        </div> --}}
<!-- Overlay -->
<div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
  <!-- Modal box -->
  <div id="modalBox" class="bg-white p-6 rounded-xl shadow-lg transform scale-95 opacity-0 transition duration-300 ease-out w-full max-w-md">
    <h2 class="text-xl font-semibold mb-4">Detail Topup</h2>
    <p><strong>Order ID:</strong> <span id="modalOrderId"></span></p>
    <p><strong>Status:</strong> <span id="modalStatus"></span></p>
    <p><strong>Waktu:</strong> <span id="modalTransactionTime"></span></p>
    <p><strong>Metode:</strong> <span id="modalPaymentType"></span></p>
    <p><strong>Nominal:</strong> <span id="modalAmount"></span></p>
    <button onclick="closeModal()" class="mt-4 bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">Tutup</button>
  </div>
</div>



<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
document.getElementById('topup-form').addEventListener('submit', function (e) {
    e.preventDefault();
    fetch('{{ route("topup.process") }}', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json',
    },
    body: JSON.stringify({
         amount: document.querySelector('[name="amount"]').value.replace(/[^0-9]/g, ""),

    })
})
.then(async response => {
    const text = await response.text();
    try {
        const data = JSON.parse(text);
        const orderId = data.order_id;
        window.snap.pay(data.token, {
            onSuccess: function(result) {
                

                window.location.href = "{{ url('/invoice/user') }}/" + orderId + "?status=success";
            },
            onPending: function(result) {
                window.location.href = "{{ url('/invoice/user') }}/" + orderId + "?status=waiting";
            },
            onError: function(result) {
                 window.location.href = "{{ url('/invoice/user') }}/" + orderId + "?status=failed";
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
    const hargaInput = document.getElementById("amount");

                if (hargaInput) {
                    hargaInput.addEventListener("input", function (e) {
                        let value = e.target.value.replace(/[^0-9]/g, "");
                        if (value) {
                            e.target.value = new Intl.NumberFormat("id-ID", {
                                style: "currency",
                                currency: "IDR",
                                minimumFractionDigits: 0
                            }).format(value);
                        } else {
                            e.target.value = "";
                        }
                    });

                    // Format nilai awal jika ada
                    let initialValue = hargaInput.value.replace(/[^0-9]/g, "");
                    if (initialValue) {
                        hargaInput.value = new Intl.NumberFormat("id-ID", {
                            style: "currency",
                            currency: "IDR",
                            minimumFractionDigits: 0
                        }).format(initialValue);
                    }

                    // Sebelum submit, hilangkan format dan kirim angka asli saja
                    
                }
            });




</script>
@endsection
