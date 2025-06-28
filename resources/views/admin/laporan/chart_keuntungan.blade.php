@extends('layouts.app')

@section('title', 'Keuntungan')

@section('content')
<x-page-header2
    title=""
    :breadcrumbs="[
        ['label' => 'Home ', 'url' => '/transaksi'],
        
    ]"
/>

    <div class="p-1 grid grid-cols-1 gap-4 ">


    <div class="bg-white border-4 border-indigo-200 border-t-sky-500 rounded-xl shadow-xl p-6 mt-6">
        <h2 class="mb-6 text-2xl text-center font-bold mb-10">Keuntungan Bulanan</h2>
        <button onclick="exportPDF()" class="btn mt-3 bg-sky-500 hover:bg-gray-300"><i data-lucide="file-output"></i>PDF</button>
<div class="card shadow-sm mt-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">Grafik Pendapatan & Pengeluaran Bulanan</h5>

    </div>
    <div class="card-body">
        <canvas id="labaChart" height="100"></canvas>
    </div>
</div>

<div class="mt-3">
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-left-primary">
            <div class="card-body">
                <h6 class="text-primary">Total Pendapatan Parkir</h6>
                <h4 class="font-weight-bold">Rp{{ number_format($data->sum(fn($d) => $d->total_kredit), 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-left-danger">
            <div class="card-body">
                <h6 class="text-danger">Total Top-up (Pengeluaran)</h6>
                <h4 class="font-weight-bold">Rp{{ number_format($data->sum(fn($d) => $d->total_debit), 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-left-success">
            <div class="card-body">
                <h6 class="text-success">Keuntungan Bersih</h6>
                <h4 class="font-weight-bold">Rp{{ number_format($data->sum(fn($d) => $d->laba), 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('laporan.export') }}" id="pdfForm" method="POST">
    @csrf
    <input type="hidden" name="chart" id="chart_image">
    <input type="hidden" name="laporan_data" value="{{ base64_encode(json_encode($data)) }}">

</form>



    </div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('labaChart').getContext('2d');

    const data = {
        labels: {!! json_encode($data->map(fn($d) => $d->bulan . '-' . $d->tahun)) !!},
        datasets: [
            {
                label: 'Kredit',
                data: {!! json_encode($data->map(fn($d) => $d->total_kredit)) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            },
            {
                label: 'Debit',
                data: {!! json_encode($data->map(fn($d) => $d->total_debit)) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.6)'
            },
            {
                label: 'Laba',
                data: {!! json_encode($data->map(fn($d) => $d->laba)) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.6)'
            }
        ]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    new Chart(ctx, config);


    function downloadChartPDF() {
     domtoimage.toPng(document.getElementById('labaChart')).then(function (dataUrl) {
        const docDefinition = {
            content: [
                { text: 'Laporan Transaksi', style: 'header' },
                {
                    image: dataUrl,
                    width: 500
                }
            ],
            styles: {
                header: {
                    fontSize: 18,
                    bold: true,
                    marginBottom: 15
                }
            }
        };
        pdfMake.createPdf(docDefinition).download("laporan-transaksi-grafik.pdf");
    });
}

function exportPDF() {
        const canvas = document.getElementById('labaChart');
        const image = canvas.toDataURL('image/png'); // Convert to Base64 PNG
        document.getElementById('chart_image').value = image;
        document.getElementById('pdfForm').submit();
    }
</script>

@endsection