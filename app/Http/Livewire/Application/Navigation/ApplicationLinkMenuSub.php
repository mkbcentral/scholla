<?php

namespace App\Http\Livewire\Application\Navigation;

use App\Models\AppLink;
use App\Models\SubAppLink;
use Livewire\Component;

class ApplicationLinkMenuSub extends Component
{
    public   $menuSubLinkList = [];
    public function mount()
    {
        if (request()->route()->parameters()) {
            $id = request()->route()->parameters()['appLink'];
            $this->menuSubLinkList = SubAppLink::where('app_link_id', $id)->get();
        } else {
            $id = substr(url()->previous(), -1);
            $this->menuSubLinkList = SubAppLink::where('app_link_id', $id)->get();
        }
    }
    public function render()
    {
        return view('livewire.application.navigation.application-link-menu-sub');
    }
}
