<div>
    <x-loading-indicator />
    <div>
        <div class="d-flex justify-content-between">
            <div><h4 class="text-uppercase text-bold text-secondary">Liste des emetteurs</h4></div>
            <div>
                <x-button class="btn-info" type="button" data-toggle="modal" data-target="#formEmitModal">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    Nouvel emetteur
                </x-button
            ></div>
        </div>

        <table class="table table-stripped table-sm mt-4">
            <thead class="thead-light">
                <tr class="text-uppercase">
                    <th>Emetteur</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($emitters as $emitter)
                    <tr>
                        <td>{{$emitter->name}}</td>
                        <td class="text-center ">
                            <x-button data-toggle="modal" data-target="#formEmitModal"
                                 type='button' wire:click.prevent='edit({{$emitter}})'
                                 class="text-primary"><i class="fas fa-edit"></i></x-button>
                            <x-button wire:click.prevent='showDeleteDialog({{$emitter}})' class="text-danger"><i class="fa fa-trash" aria-hidden="true"></i></x-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @include('livewire.requisition.modals.form-emit')
    </div>
</div>
