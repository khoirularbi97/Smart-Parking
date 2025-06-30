@extends('layouts.user')

@section('content')
<style>
   @media print {
        body * {
            visibility: hidden !important;
        }

        #invoice-print, #invoice-print * {
            visibility: visible !important;
        }

        #invoice-print {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px;
        }

        .no-print {
            display: none !important;
        }
    }
</style>
<div class="flex items-center justify-center py-10"  id="invoice-print">
    <div class="bg-white border-4 border-purple-200 border-b-purple-500 w-[360px] rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-pink-400 to-purple-500  text-white text-center py-4 relative">
            <a href="{{ route('topup.form') }}" class="absolute left-4 top-4 text-white text-xl">&#8592;</a>
            <p class="text-sm font-medium">#{{ $invoice->order_id }}</p>

            <div class="mt-2">
                <div class="w-20 h-20 mx-auto bg-white rounded-full flex items-center justify-center shadow-md">
                    @if ($invoice->status === 'success')
                        <i data-lucide="circle-check-big" class="w-10 h-10 text-green-600"></i>
                    @elseif ($invoice->status === 'pending')
                        <i data-lucide="timer" class="w-10 h-10 text-yellow-500"></i>
                    @else 
                        <i data-lucide="x-circle" class="w-10 h-10 text-red-600"></i>
                    @endif
                </div>

                <p class="text-xs mt-2 font-bold tracking-wide uppercase">
                    {{ strtoupper($invoice->status) }}
                </p>
            </div>
        </div>

        <!-- Invoice Card -->
        <div class="bg-white rounded-xl -mt-5 px-6 pt-6 pb-8 text-gray-700 text-sm">
            <div class="flex justify-between mb-4">
                <div>
                    <p class="text-xs text-gray-400 font-medium">ORDER #</p>
                    <p class="font-semibold">{{ $invoice->order_id }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400 font-medium">DUE ON</p>
                    <p class="font-semibold">{{ \Carbon\Carbon::parse($invoice->created_at)->format('M d, Y') }}</p>
                </div>
            </div>

            <div class="flex justify-between items-center bg-gray-100 rounded-lg py-3 px-4 mb-4">
                <div>
                    <p class="text-xs text-gray-500">TOPUP</p>
                    <p class="text-xl font-bold">{{ $invoice->name }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500">METODE</p>
                    <p class="text-xl font-bold">{{ strtoupper($invoice->method) }}</p>
                </div>
            </div>

            <div class="border-t pt-4 text-center">
                <p class="text-xs text-gray-400 uppercase">Total Amount</p>
                <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</p>
            </div>

            <div class="mt-6">
                <button onclick="window.print()" class="no-print bg-purple-500 hover:bg-gray-400 text-white text-center py-3 rounded-lg text-sm font-semibold shadow-md w-full ">
                    Cetak
                </button>

                <button id="downloadImage" class="no-print bg-pink-500 hover:bg-gray-400 text-white text-center py-3 rounded-lg text-sm font-semibold shadow-md w-full mt-2">🖼️ Unduh Gambar</button>

            </div>
        </div>
    </div>
    <script>
document.getElementById("downloadImage").addEventListener("click", function () {
    const invoiceElement = document.getElementById("invoice-print");

   // Sembunyikan elemen no-print (tombol)
    const noPrintElements = document.querySelectorAll('.no-print');
    noPrintElements.forEach(el => el.style.display = 'none');

    // Delay sebentar agar DOM update
    setTimeout(() => {
        html2canvas(invoiceElement, { scale: 2 }).then(canvas => {
            let link = document.createElement('a');
            link.download = 'invoice-{{ $invoice->order_id }}.png';
            link.href = canvas.toDataURL("image/png");
            link.click();

            // Tampilkan kembali tombol
            noPrintElements.forEach(el => el.style.display = '');
        });
    }, 300); // waktu 300ms cukup agar DOM benar-benar update
});
</script>

@endsection

    

