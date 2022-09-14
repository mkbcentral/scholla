<div>
    <x-loading-indicator />
    <div>
        <div class="d-flex justify-content-between">
            <div><h4 class="text-uppercase text-bold text-secondary">Liste des requisition</h4></div>
            <div>
                <x-button wire:click.prevent='changeEditableState' class="btn-info" type="button" data-toggle="modal" data-target="#formReqModal">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    Créer un nouvelle requisition
                </x-button
            ></div>
        </div>

        <table class="table table-stripped table-sm mt-4">

            <thead class="thead-light">
                <tr class="text-uppercase">
                    <th>N°</th>
                    <th>Code</th>
                    <th class="text-center">Emitteur</th>
                    <th class="text-center">NBRE</th>
                    <th class="text-right">Montant</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requisitions as $index => $requisitions)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$requisitions->code}}</td>
                        <td class="text-center">{{$requisitions->emetter->name}}</td>
                        <td class="text-center">{{$requisitions->details->count()}}</td>
                        <td class="text-right">{{$requisitions->getTotal($requisitions->id)}}</td>
                        <td class="text-center ">
                            <x-button data-toggle="modal" data-target="#formShowDetailModal"
                                 type='button' wire:click.prevent='showDetails({{$requisitions}})'
                                 class="text-secondary"><i class="fas fa-eye"></i></x-button>
                            <x-button data-toggle="modal" data-target="#formAddDetailModal"
                                 type='button' wire:click.prevent='edit({{$requisitions}})'
                                 class="text-info"><i class="fas fa-plus"></i></x-button>
                            <x-button data-toggle="modal" data-target="#formReqModal"
                                 type='button' wire:click.prevent='edit({{$requisitions}})'
                                 class="text-primary"><i class="fas fa-edit"></i></x-button>
                            <x-button wire:click.prevent='showDeleteDialog({{$requisitions}})'
                                class="text-danger"><i class="fa fa-trash" aria-hidden="true"></i></x-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @include('livewire.requisition.modals.form-requisition')
        @include('livewire.requisition.modals.form-add-depense')
        @include('livewire.requisition.modals.show-detail-reqs')
    </div>
</div>
