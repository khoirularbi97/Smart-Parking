@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 bg-primary text-white sidebar">
            <h4 class="p-3">E PARKING</h4>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link text-white" href="#">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Transaksi</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Pengaturan</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Registrasi</a></li>
            </ul>
        </div>
        <div class="col-md-10">
            <h2 class="mt-3">Dashboard</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5>JUMLAH MEMBER</h5>
                            <h3>2</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5>JUMLAH ADMIN</h5>
                            <h3>1</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5>DATA TRANSAKSI KREDIT</h5>
                            <h3>2</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5>DATA TRANSAKSI DEBIT</h5>
                            <h3>3</h3>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="mt-4">Top Up Saldo</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>UID</th>
                        <th>Nama</th>
                        <th>Saldo</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>783492182007</td>
                        <td>Dio Toar</td>
                        <td>Rp 39.000</td>
                        <td><button class="btn btn-success">✔</button></td>
                    </tr>
                    <tr>
                        <td>1061221907742</td>
                        <td>Gladys</td>
                        <td>Rp 25.000</td>
                        <td><button class="btn btn-success">✔</button></td>
                    </tr>
                </tbody>
            </table>
            <h4 class="mt-4">Data Transaksi</h4>
            <canvas id="chartTransaksi"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('chartTransaksi').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Debit', 'Top Up'],
            datasets: [{
                data: [3, 2],
                backgroundColor: ['#007bff', '#343a40']
            }]
        }
    });
</script>
@endsection
