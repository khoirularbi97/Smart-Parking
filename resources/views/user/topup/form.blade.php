@extends('layouts.user')

@section('content')
<div class="max-w-md mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">Topup Saldo</h2>
    <form id="topup-form">
        @csrf
        <input type="number" name="amount" placeholder="Masukkan jumlah topup" required class="w-full border p-2 rounded mb-4" />

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Topup</button>
    </form>
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
