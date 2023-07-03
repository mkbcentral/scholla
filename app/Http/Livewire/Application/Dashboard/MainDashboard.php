<?php

namespace App\Http\Livewire\Application\Dashboard;

use App\Models\AppLink;
use Livewire\Component;

class MainDashboard extends Component
{
    public function mount(){

    }
    public function render()
    {
        return view('livewire.application.dashboard.main-dashboard');
    }
}
