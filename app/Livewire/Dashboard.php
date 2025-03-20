<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Transaction;

class Dashboard extends Component
{
    public $jumlahMember, $jumlahAdmin, $transaksiKredit, $transaksiDebit;

    protected $listeners = ['transactionUpdated' => 'mount'];

    public function mount()
    {
        $this->jumlahMember = User::where('role', 'user')->count();
        $this->jumlahAdmin = User::where('role', 'admin')->count();
        $this->transaksiKredit = Transaction::where('type', 'credit')->count();
        $this->transaksiDebit = Transaction::where('type', 'debit')->count();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
