<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Transaction;

class Dashboard extends Component
{
    public $jumlahMember ;
    
    public function mount()
    {
        $this->jumlahMember = User::where('role', 'admin')->count();
       
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
