{{-- Invoice Content --}}
    <div class="card invoice p-4 shadow rounded">
        <h2 class="text-center">INVOICE PEMBAYARAN</h2>
        <hr>

        <div class="row">
            <div class="col-md-6">
                <p><strong>Invoice ID:</strong> INV-{{$invoice->orderId }}</p>
                <p><strong>Tanggal:</strong> {{ now()->format('d M Y, H:i') }}</p>
            </div>
            <div class="col-md-6 text-end">
                <p><strong>Nama Pelanggan:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
            </div>
        </div>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Top Up Saldo</td>
                    <td>1</td>
                    <td>Rp {{ number_format($invoice->amount ?? 0, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($invoice->amount ?? 0, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="text-end mt-3">
            <h5>Total: <strong>Rp {{ number_format($invoice->amount ?? 0, 0, ',', '.') }}</strong></h5>
        </div>

        <p class="mt-4">Terima kasih telah melakukan pembayaran. Simpan invoice ini sebagai bukti transaksi Anda.</p>
    </div>
</div>

{{-- Script Auto Print Jika Redirect dari Midtrans --}}
@if(request('status') === 'success')
<script>
    window.onload = function() {
        window.print();
    };
</script>
@endif
@endsection

@section('styles')
<style>
    @media print {
        body * {
            visibility: hidden;
        }

        .invoice, .invoice * {
            visibility: visible;
        }

        .invoice {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        .no-print {
            display: none !important;
        }
    }
</style>
@endsection