<div>
    <x-loading-indicator />
    <div class="d-flex justify-content-between">
        <div><h4 class="text-uppercase text-bold text-secondary">Liste des classes</h4></div>
        <div>

        </div>
        <div>
            <x-button class="btn-info" type="button" data-toggle="modal" data-target="#formclasseModal">
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                Créer un nouvelle classe
            </x-button
        ></div>
    </div>
    <div class="form-group w-25">
        <x-label value="{{ __('Filtrer par option') }}" />
        <x-select wire:model='option_id_serach'>
            <option value="">Choisir...</option>
            @foreach ($options as $option)
                <option value="{{$option->id}}">{{$option->name}}</option>
            @endforeach
        </x-select>
    </div>
    <table class="table table-stripped table-sm mt-4">
        <thead class="thead-light">
            <tr class="text-uppercase">
                <th>Nom de l'option</th>
                <th class="text-center">Eleves</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($classes as $classe)
                <tr>
                    <td>{{$classe->name.'/'.$classe->option->name}}</td>
                    <td class="text-center">{{$classe->students->count()}}</td>
                    <td class="text-center">
                        <x-button wire:click.prevent='edit({{$classe}})' class="btn-sm" type="button" data-toggle="modal" data-target="#formclasseModal">
                           <i class="fas fa-edit text-primary"></i>
                        </x-button>
                        <x-button wire:click.prevent='showDeleteDialog({{$classe}})' class="text-danger"><i class="fa fa-trash" aria-hidden="true"></i></x-button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{$classes->links('livewire::bootstrap')}}
    </div>
    @include('livewire.school.modals.form-classe')
</div>
