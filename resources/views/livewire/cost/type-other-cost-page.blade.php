<div>
    <x-loading-indicator />
    <div>
        <div class="d-flex justify-content-between">
            <div><h4 class="text-uppercase text-bold text-primary">Liste autres frais</h4></div>
            <div>
                @if (Auth::user()->roles->pluck('name')->contains('Admin') or
                    Auth::user()->roles->pluck('name')->contains('root'))
                    <x-button wire:click.prevent='resetFormState' class="btn-info" type="button"
                             data-toggle="modal" data-target="#formTypeCostotherModal">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        Créer un nouveau type
                    </x-button>
                @endif

                </div>
        </div>
        <table class="table table-stripped table-sm mt-4">
            <thead class="thead-light">
                <tr class="text-uppercase">
                    <th>Frais</th>
                    <th class="text-center">Etat</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($types as $type)
                    <tr>
                        <td>{{$type->name}}</td>
                        <td class="text-center">
                            @if ($type->active==true)
                                <span class="text-success">Activé</span>
                            @else
                                <span class="text-danger">Déactivé</span>
                            @endif
                        </td>
                        <td class="text-center ">
                            @if (Auth::user()->roles->pluck('name')->contains('Admin') or
                                Auth::user()->roles->pluck('name')->contains('root'))
                            <x-button class="btn-sm" data-toggle="modal" data-target="#formTypeCostotherModal"
                                        type='button' wire:click.prevent='edit({{$type}})'
                                        class="text-primary"><i class="fas fa-edit"></i></x-button>
                                <x-button wire:click.prevent='showDeleteDialog({{$type}})' class="text-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></x-button>
                            @else
                                <span>Ok</span>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('livewire.cost.modals.form-type-cost-other')
</div>
