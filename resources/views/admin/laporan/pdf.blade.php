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
           
        }
        
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
            margin-bottom: 50px; 
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 6px; 
            text-align: center; 
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
    <div style="text-align: center;" class="title" style="margin-bottom: 30px ">Laporan Grafik Keuntungan Bulanan</div>
    <!-- Chart -->
    <div class="chart  " style="margin-bottom: 50px ">
        <img src="{{ $chartBase64 }}" style="width: 100%;">

    </div>


   
    

    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Total Kredit</th>
                <th>Total Debit</th>
                <th>Laba</th>
            </tr>
        </thead>
        <tbody>
                @if(is_array($data))
                    @php
                        $bulanNama = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                            4 => 'April', 5 => 'Mei', 6 => 'Juni',
                            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                    @endphp
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $bulanNama[$row['bulan']] ?? 'Tidak Diketahui' }} {{ $row['tahun'] }}</td>
                            <td>Rp{{ number_format($row['total_kredit'], 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($row['total_debit'], 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($row['laba'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">Tidak ada data</td>
                    </tr>
                @endif
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




<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Grafik Keuntungan</title>
    <style>
        
    </style>
</head>
<body>
    
</body>
</html>
