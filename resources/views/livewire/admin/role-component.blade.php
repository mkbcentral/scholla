<div>
    <div class="d-flex justify-content-between">
        <div><h4 class="text-uppercase text-bold text-secondary">Liste des roles</h4></div>
        <div>
            <x-button class="btn-info" type="button"
            data-toggle="modal" data-target="#CreateRoleModal">
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                Créer un nouveau role
            </x-button
        ></div>
    </div>

    <table class="table table-light mt-4">
        <thead class="thead-light">
            <tr class="text-uppercase">
                <th>Role</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $index => $role)
                <tr>
                    <td>{{$role->name}}</td>
                    <td class="text-center">
                        <x-button class="text-primary btn-sm"
                            data-toggle="modal" data-target="#EditRoleModal"
                            wire:click.prevent='edit({{$role}})'> <i class="fas fa-edit"></i></x-button>
                        <x-button class="text-danger btn-sm"
                            wire:click.prevent='showDialog({{$role}})'> <i class="fa fa-trash" aria-hidden="true"></i>
                        </x-button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @include('livewire.admin.modals.create-role')
    @include('livewire.admin.modals.edit-role')

</div>
