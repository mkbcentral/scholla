<div>
    <x-loading-indicator />
    <div class="d-flex justify-content-between">
        <div><h4 class="text-uppercase text-bold text-secondary">Liste des utilisateurs</h4></div>
        <div>
            <x-button class="btn-info" type="button" data-toggle="modal" data-target="#CreateUserModal">
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                Créer un nouvel utilisateur
            </x-button
        ></div>
    </div>

    <table class="table table-light mt-4">
        <thead class="thead-light">
            <tr class="text-uppercase">
                <th>Nom de l'utilisateur</th>
                <th>Adresse email</th>
                <th>Roles</th>
                <th>Etat</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{implode(" | ",$user->roles->pluck('name')->toArray())}}</td>
                    <td>Actif</td>
                    <td class="text-center">
                        @if ($user->name=='root')
                            -
                        @else
                            <x-button class="text-primary btn-sm"  data-toggle="modal" data-target="#EditUserModal"
                            wire:click.prevent='edit({{$user}})'> <i class="fas fa-edit"></i></x-button>
                            <x-button class="text-danger btn-sm"
                            wire:click.prevent='showDialog({{$user}})'> <i class="fa fa-trash" aria-hidden="true"></i></x-button>
                        @endif

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @include('livewire.admin.modals.create-user')
    @include('livewire.admin.modals.edit-user')
</div>
