<?php

namespace App\Http\Livewire\Admin;

use App\Models\AppSetting;
use Livewire\Component;

class AppSettings extends Component
{
    public $setting,$name;
    public function mount(){
        $this->setting=AppSetting::where('id',1)->first();
        if ($this->setting) {
            $this->name=$this->setting->printer_name;;
        }


    }
    public function save(){
        $this->validate(['name'=>'required']);
        if ($this->setting) {
            $this->setting->printer_name=$this->name;
            $this->setting->update();
            $this->dispatchBrowserEvent('data-updated',['message'=>'Paramètre bien modifié']);
        } else {
            $setting=new AppSetting();
            $setting->printer_name=$this->name;
            $setting->save();
            $this->dispatchBrowserEvent('data-updated',['message'=>'Paramètres bien défini']);
        }

    }
    public function render()
    {
        return view('livewire.admin.app-settings');
    }
}
