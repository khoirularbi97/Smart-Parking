<form id="topup-form">
    <input type="number" name="amount" id="amount" placeholder="Masukkan jumlah saldo" required>
    <button type="submit" class="bg-blue-500 px-4 py-2 text-white rounded">Top Up</button>
</form>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
document.getElementById('topup-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const amount = document.getElementById('amount').value;

    fetch("{{ route('topup.process') }}", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({ amount: amount })
    })
    .then(res => res.json())
    .then(data => {
        snap.pay(data.token, {
            onSuccess: function(result) {
                alert("Pembayaran berhasil!");
                location.reload();
            },
            onPending: function(result) {
                alert("Menunggu pembayaran...");
            },
            onError: function(result) {
                alert("Terjadi kesalahan saat pembayaran.");
            }
        });
    });
});
</script>
