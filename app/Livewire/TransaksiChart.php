<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class TransaksiChart extends Component
{
    public $labels = [];
    public $data = [];

    protected $listeners = ['updateChart' => 'fetchData'];

    public function mount()
    {
        $this->fetchData();
    }

    public function fetchData()
    {
        $transaksi = Transaksi::select(
                DB::raw("DATE_FORMAT(created_at, '%H:%i') as waktu"),
                DB::raw("SUM(CASE WHEN jenis = 'kredit' THEN jumlah ELSE 0 END) as kredit"),
                DB::raw("SUM(CASE WHEN jenis = 'debit' THEN jumlah ELSE 0 END) as debit")
            )
            ->groupBy('waktu')
            ->orderBy('waktu', 'asc')
            ->get();

        $this->labels = $transaksi->pluck('waktu')->toArray();
        $this->data = [
            'kredit' => $transaksi->pluck('kredit')->toArray(),
            'debit' => $transaksi->pluck('debit')->toArray()
        ];
    }

    public function render()
    {
        return view('livewire.transaksi-chart');
    }
}

