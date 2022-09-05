<div>
    <x-loading-indicator />
    <div>
        <div class="d-flex justify-content-between">
            <div><h4 class="text-uppercase text-bold text-primary">Liste autres frais</h4></div>
            <div>
                <x-button wire:click.prevent='resetFormState' class="btn-info" type="button" data-toggle="modal" data-target="#formCostotherModal">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    Créer un nouveau frais
                </x-button
            ></div>
        </div>
        <table class="table table-stripped table-sm mt-4">
            <thead class="thead-light">
                <tr class="text-uppercase">
                    <th>Frais</th>
                    <th class="text-center">Montant</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($costs as $cost)
                    <tr>
                        <td>{{$cost->name}}</td>
                        <td class="text-center">{{$cost->amount}} USD</td>
                        <td class="text-center ">
                            <x-button class="btn-sm" data-toggle="modal" data-target="#formCostotherModal"
                                 type='button' wire:click.prevent='edit({{$cost}})'
                                 class="text-primary"><i class="fas fa-edit"></i></x-button>
                            <x-button wire:click.prevent='showDeleteDialog({{$cost}})' class="text-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></x-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{$costs->links('livewire::bootstrap')}}
        </div>

    </div>
    @include('livewire.cost.modals.form-cost-other')
</div>
