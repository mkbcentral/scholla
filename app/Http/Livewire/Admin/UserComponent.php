<?php

namespace App\Http\Livewire\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserComponent extends Component
{
    public $roles=[],$roles_id=[];
    public $state=[];
    public $user,$userToDelete;
    protected $listeners=['deleteUserListener'=>'delete'];
    public function mount(){
        $this->roles=Role::all();
    }
    public function store(){
        //dd($this->roles_id);
        $user=new User();
        $user->name=$this->state['name'];
        $user->email=$this->state['email'];
        $user->password=Hash::make('mpassword');
        $user->save();
        $user->roles()->attach($this->roles_id);
        $this->dispatchBrowserEvent('data-added',['message'=>"Utlistatuer bien ajouté !"]);
    }

    public function edit(User $user){
        $this->state['name']=$user->name;
        $this->state['email']=$user->email;
        $this->user=$user;
    }

    public function update(){
        $this->user->name= $this->state['name'];
        $this->user->email= $this->state['email'];
        $this->user->update();
        $this->user->roles()->detach();
        if($this->roles_id !=[]){
            $this->user->roles()->attach($this->roles_id);
        }
        $this->dispatchBrowserEvent('data-updated',['message'=>"Utlistatuer bien mis à jour !"]);
    }
    public function showDialog(User $user){
        $this->userToDelete=$user;
        $this->dispatchBrowserEvent('delete-user-dialog');
    }
    public function delete(){
        $this->userToDelete->roles()->detach();
        $this->userToDelete->delete();
        $this->dispatchBrowserEvent('data-deleted',['message'=>"Utlistatuer bien rétiré !"]);
    }
    public function render()
    {
        $users=User::with('roles')->paginate(20);
        return view('livewire.admin.user-component',['users'=>$users]);
    }
}
