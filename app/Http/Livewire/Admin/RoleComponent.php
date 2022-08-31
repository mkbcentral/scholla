<?php

namespace App\Http\Livewire\Admin;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RoleComponent extends Component
{
    public $state=[];
    public $role,$roleToDelete,$permissions=[],
            $permissions_id=[],$roleToAssign,$roleToDetach;
    protected $listeners=['deleteRoleListener'=>'delete'];

    public function mount(){
        $this->permissions=Permission::orderBy('name','ASC')->get();
    }
    public function store(){
        $role=new Role();
        $role->name=$this->state['name'];
        $role->save();
        $this->dispatchBrowserEvent('data-added',['message'=>"Role bien ajouté !"]);
    }

    public function edit(role $role){
        $this->state['name']=$role->name;
        $this->role=$role;
    }

    public function update(){
        $this->role->name= $this->state['name'];
        $this->role->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Role bien mis à jour !"]);
    }
    public function showDialog(Role $role){
        $this->roleToDelete=$role;
        $this->dispatchBrowserEvent('delete-role-dialog');
    }
    public function delete(){
        if ($this->roleToDelete->users->isEmpty()) {
            $this->roleToDelete->delete();
            $this->dispatchBrowserEvent('data-deleted',['message'=>"Role bien rétiré !"]);
        } else {
            $this->dispatchBrowserEvent('data-updated',['message'=>"Attention ce role est attaché à utilisateur !"]);
        }


    }

    public function showAssingPermissions(Role $role){
        $this->roleToAssign=$role;
    }
    public function showDetachPermissions(Role $role){
        $this->roleToDetach=$role;
    }
    public function assignPermission(){
        $this->roleToAssign->permissions()->attach($this->permissions_id);
        $this->dispatchBrowserEvent('data-updated',['message'=>"Permissions bien assignées !"]);
    }

    public function detachPermission($id){
        DB::table('permission_role')->where('id',$id)->delete();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Permissions rtirée !"]);
    }
    public function render()
    {
        $roles=Role::orderBy('name','ASC')
            ->with('users')
            ->get();
        return view('livewire.admin.role-component',['roles'=>$roles]);
    }
}
