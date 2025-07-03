<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 40px;
            font-size: 14px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
         .bg-green-200{
            background-color: #1cdb2c;
            padding: 4px;
        }
        .bg-yellow-200{
            background-color: #f3f057;
             padding: 4px;
        }
        .bg-red-200 {
             background-color: #dd180a;
             padding: 4px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
        }
        .header p {
            margin: 2px;
            font-size: 13px;
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px 10px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        .footer {
            width: 100%;
            margin-top: 30px;
        }
        .footer .left {
            float: left;
            width: 50%;
        }
        .footer .right {
            float: right;
            width: 50%;
            text-align: center;
        }
        .footer p {
            margin: 4px 0;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
{{-- 
    <!-- Kop Surat -->
    <div class="header">
        <h1>PT. Smart Parking</h1>
        <p>Jl. Inspeksi Kalimalang Tegal Danas Arah Deltamas, Cibatu, Cikarang, Bekasi ,Jawa Barat Indonesia 17532</p>
        <p>Email: arinklise@khoirularbi.com | Telp: (021) 12345678</p>
    </div> --}}
<!-- Kop Surat -->
<div style="display: flex; align-items: center; margin-bottom: 20px;">
    <!-- Logo di kiri -->
    <div style="flex-shrink: 0; margin-left: 20px">
        <img src="{{ public_path('images/logo1.png') }}" alt="Logo" style="height: 25px;">
    </div>

    <!-- Teks di kanan -->
    <div style="margin-left: 20px">
        <div style="font-weight: bold; font-size: 18px;"> PT SMART PARKING SOLUTION</div>
        <div>Jl. Inspeksi Kalimalang Tegal Danas Arah Deltamas, Cibatu, Cikarang, Bekasi ,Jawa Barat Indonesia 17532</div>
        <div>Email: arinklise@khoirularbi.com | Telp: (021) 12345678</div>
    </div>
    <hr style="border-top: 2px solid #000; margin-bottom: 30px;">
    
    <!-- Judul Laporan -->
    <div class="title" style="margin-bottom: 30px ">LAPORAN RIWAYAT PARKIR</div>
    <!-- Chart -->
    <div class="chart " style="margin-bottom: 30px ">
        <img src="{{ $chartBase64Biaya }}" style="width: 100%;">

    </div>
    <div class="chart " style="margin-bottom: 30px ">
        <img src="{{ $chartBase64Kendaraan }}" style="width: 100%;">

    </div>


    <!-- Tabel Transaksi -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>UID</th>
                <th>Durasi</th>
                <th>Status</th>
                <th>Waktu Masuk</th>
                <th>Waktu Keluar</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayat_parkir as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->uid }}</td>
                    <td>{{ $item->durasi }}</td>
                    <td> <span class="px-2 py-1 rounded text-xs font-semibold 
                                    {{ $item->_Status == '1' ? 'bg-green-200' : 'bg-yellow-200 text-yellow-800' }}">{{ $item->_Status == '1' ? 'Success' : 'Menunggu' }}</span></td>
                    <td>{{ \Carbon\Carbon::parse($item->waktu_masuk)->format('d M Y H:i') }}</td>
                    <td>{{ $item->waktu_keluar ? \Carbon\Carbon::parse($item->waktu_keluar)->format('d M Y H:i') : '0000-00-00 00:00:00' }}</td>
                    <td>Rp {{ number_format($item->biaya, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer Tanda Tangan -->
    <div class="footer">
        <div class="left">
            <p>Dicetak pada: {{ date('d-m-Y') }}</p>
        </div>
        <div class="right">
            <p>Mengetahui,</p>
            <br><br><br>
            <p><strong>________________________</strong></p>
            <p>Manager Keuangan</p>
        </div>
    </div>

</body>
</html>
