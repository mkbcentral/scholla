<?php

namespace App\Http\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;

class SettingComponent extends Component
{
    use WithFileUploads;
    public $app_name,$email,$phone,$logo,$setting;
    public function mount(){
        $this->setting=Setting::find(1);
        if ($this->setting) {
            $this->app_name=$this->setting->app_name;
            $this->email=$this->setting->email;
            $this->phone=$this->setting->phone;
        }
    }
    public function save(){
        $this->validate([
            'app_name'=>'required',
            'email'=>'nullable',
            'phone'=>'nullable',
            'logo' => 'nullable|image|max:1024', // 1MB Max
        ]);

        if ($this->setting) {

            $this->app_name=$this->setting->app_name;
            $this->email=$this->setting->email;
            $this->phone=$this->setting->phone;
            if ($this->logo) {
                $this->setting->app_logo=$this->getLogo($this->logo);
            }
            $this->setting->app_name=$this->app_name;
            $this->setting->email=$this->email;
            $this->setting->email=$this->email;

            $this->setting->update();
            $this->dispatchBrowserEvent('data-updated',['message'=>'Paramètres bien sauvegarder']);
        } else {
            $setting=new Setting();
            $setting->app_name=$this->app_name;
            $setting->email=$this->email;
            $setting->email=$this->email;
            $setting->app_logo=$this->getLogo($this->logo);
            $setting->save();
            $this->dispatchBrowserEvent('data-added',['message'=>'Paramètres bien sauvegarder']);
        }

    }
    public function getLogo($logo){
        if ($logo) {
            $logo_name=time().'_'.$logo->getClientOriginalName();
            $logo_path = $logo->storeAs('logo', $logo_name,'public');
            return $logo_path;
        }else{
            return null;
        }
    }
    public function render()
    {
        return view('livewire.admin.setting-component');
    }
}
