<?php

namespace App\Http\Livewire\Application\Navigation;

use App\Models\AppLink;
use Livewire\Component;

class ApplicationLinkMenu extends Component
{
    public function render()
    {
        $appLinks=AppLink::inRandomOrder()
        ->get();
        return view('livewire.application.navigation.application-link-menu',['appLinks'=>$appLinks]);
    }
}
