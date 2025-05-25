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
      <input type="number" name="amount" placeholder="Contoh: 10000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400 focus:outline-none mb-4" required />
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
                    <p class="font-bold text-sm">{{ $history->status ?? 'Nama Tidak Diketahui' }}</p>
                    <p class="text-xs text-gray-500">{{ $history->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
            <div class="text-right text-purple-700 font-semibold">
                Rp {{ number_format($history->amount, 0, ',', '.') }}
            </div>
        </div>
        <p class="text-xs mt-2 text-purple-500">Riwayat topup</p>
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
        amount: document.querySelector('[name="amount"]').value
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

</script>
@endsection
