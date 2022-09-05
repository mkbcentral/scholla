<div>
    <x-loading-indicator />
    <div>
        <div class="d-flex justify-content-between">
            <div><h4 class="text-uppercase text-bold text-secondary">Liste des sections</h4></div>
            <div>
                <x-button class="btn-info" type="button" data-toggle="modal" data-target="#formSectionModal">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    Créer un nouvelle section
                </x-button
            ></div>
        </div>

        <table class="table table-stripped table-sm mt-4">
            <thead class="thead-light">
                <tr class="text-uppercase">
                    <th>Nom de la section</th>
                    <th class="text-center">Options</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sections as $section)
                    <tr>
                        <td>{{$section->name}}</td>
                        <td class="text-center">{{$section->options->count()}}</td>
                        <td class="text-center ">
                            <x-button data-toggle="modal" data-target="#formSectionModal"
                                 type='button' wire:click.prevent='edit({{$section}})'
                                 class="text-primary"><i class="fas fa-edit"></i></x-button>
                            <x-button wire:click.prevent='showDeleteDialog({{$section}})' class="text-danger"><i class="fa fa-trash" aria-hidden="true"></i></x-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @include('livewire.school.modals.form-section')
    </div>
</div>
