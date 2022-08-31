<div>
    <div>
        <div class="d-flex justify-content-between">
            <div><h4 class="text-uppercase text-bold text-primary">Liste devise</h4></div>
            <div>
                <x-button wire:click.prevent='resetFormState' class="btn-info" type="button" data-toggle="modal" data-target="#formDeviseModal">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    Créer un nouvelle devise
                </x-button
            ></div>
        </div>

        <table class="table table-stripped table-sm mt-4">
            <thead class="thead-light">
                <tr class="text-uppercase">
                    <th>Devise</th>
                    <th class="text-center">Taux</th>
                    <th class="text-center">Etat</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($devises as $devise)
                    <tr>
                        <td>{{$devise->name}}</td>
                        <td class="text-center">{{$devise->taux}}</td>
                        <td class="text-center">
                            @if ($devise->active==false)
                                <span class="text-danger">Désactivée !</span>
                            @else
                                <span class="text-success">Activée !</span>
                            @endif
                        </td>
                        <td class="text-center ">
                            <x-button class="btn-sm" data-toggle="modal" data-target="#formDeviseModal"
                                 type='button' wire:click.prevent='edit({{$devise}})'
                                 class="text-primary"><i class="fas fa-edit"></i></x-button>
                            <x-button wire:click.prevent='showDeleteDialog({{$devise}})' class="text-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></x-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    @include('livewire.cost.modals.form-cost-devise')
</div>
