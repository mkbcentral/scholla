<div>
    <div class="d-flex justify-content-between">
        <div><h4 class="text-uppercase text-bold text-secondary">Liste des options</h4></div>
        <div>

        </div>
        <div>
            <x-button class="btn-info" type="button" data-toggle="modal" data-target="#formOptionModal">
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                Créer un nouvelle option
            </x-button
        ></div>
    </div>
    <div class="form-group w-25">
        <x-label value="{{ __('Filtrer par section') }}" />
        <x-select wire:model='section_id_serach'>
            <option value="">Choisir...</option>
            @foreach ($sections as $section)
                <option value="{{$section->id}}">{{$section->name}}</option>
            @endforeach
        </x-select>
    </div>
    <table class="table table-stripped table-sm mt-4">
        <thead class="thead-light">
            <tr class="text-uppercase">
                <th>Nom de l'option</th>
                <th>section</th>
                <th class="text-center">Classe</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($options as $option)
                <tr>
                    <td>{{$option->name}}</td>
                    <td>{{$option->section->name}}</td>
                    <td class="text-center">{{$option->classes->count()}}</td>
                    <td class="text-center">
                        <x-button wire:click.prevent='edit({{$option}})' class="btn-sm" type="button" data-toggle="modal" data-target="#formOptionModal">
                           <i class="fas fa-edit text-primary"></i>
                        </x-button>
                        <x-button wire:click.prevent='showDeleteDialog({{$option}})' class="text-danger"><i class="fa fa-trash" aria-hidden="true"></i></x-button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{$options->links('livewire::bootstrap')}}
    </div>
    @include('livewire.school.modals.form-option')
</div>
