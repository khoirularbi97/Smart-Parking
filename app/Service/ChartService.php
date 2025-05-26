<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Chartisan\PHP\Chartisan;

class ChartService
{
    public function makeLineChart(array $labels, array $data): string
    {
        // Menggunakan QuickChart.io (opsi ringan untuk backend)
        $chartConfig = [
            'type' => 'line',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'label' => 'Jumlah Transaksi',
                    'data' => $data,
                    'fill' => false,
                    'borderColor' => 'rgb(75, 192, 192)',
                    'tension' => 0.1
                ]]
            ]
        ];

        $url = 'https://quickchart.io/chart?c=' . urlencode(json_encode($chartConfig));

        // Dapatkan konten base64 dari gambar chart
        $image = file_get_contents($url);
        return $image; // return as binary
    }
}
