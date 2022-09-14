<div>
    <x-loading-indicator />
    <div>
        <div class="d-flex justify-content-between">
            <div><h4 class="text-uppercase text-bold text-secondary">Liste des emetteurs</h4></div>
            <div>
                <x-button class="btn-info" type="button" data-toggle="modal" data-target="#formSourceDepsModal">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    Créer un nouvelle source
                </x-button
            ></div>
        </div>

        <table class="table table-stripped table-sm mt-4">
            <thead class="thead-light">
                <tr class="text-uppercase">
                    <th>Source</th>
                    <th>Solde</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sources as $source)
                    <tr>
                        <td>{{$source->name}}</td>
                        <td>{{$source->solde}}</td>
                        <td class="text-center ">
                            <x-button data-toggle="modal" data-target="#formSourceDepsModal"
                                 type='button' wire:click.prevent='edit({{$source}})'
                                 class="text-primary"><i class="fas fa-edit"></i></x-button>
                            <x-button wire:click.prevent='showDeleteDialog({{$source}})' class="text-danger"><i class="fa fa-trash" aria-hidden="true"></i></x-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @include('livewire.requisition.modals.form-source-dep')
    </div>
</div>
