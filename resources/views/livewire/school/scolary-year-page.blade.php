<div>
    <x-loading-indicator />
    <div>
        <div class="d-flex justify-content-between">
            <div><h4 class="text-uppercase text-bold text-secondary">Liste des années scolaires</h4></div>
            <div>
                <x-button class="btn-info" type="button" data-toggle="modal" data-target="#formScolaryYearModal">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    Créer un nouvelle année scolaire
                </x-button
            ></div>
        </div>

        <table class="table table-stripped table-sm mt-4">
            <thead class="thead-light">
                <tr class="text-uppercase">
                    <th>Anné scolaire</th>
                    <th>Etat</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($scolaryYears as $scolaryYear)
                    <tr>
                        <td>{{$scolaryYear->name}}</td>
                        <td>
                            @if ($scolaryYear->active==false)
                                <span class="text-danger">Inactif</span>
                            @else
                                <span class="text-success">En cours</span>
                            @endif
                        </td>
                        <td class="text-center ">
                            <x-button data-toggle="modal" data-target="#formScolaryYearModal"
                                 type='button' wire:click.prevent='edit({{$scolaryYear}})'
                                 class="text-primary"><i class="fas fa-edit"></i></x-button>
                            <x-button wire:click.prevent='showDeleteDialog({{$scolaryYear}})' class="text-danger"><i class="fa fa-trash" aria-hidden="true"></i></x-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @include('livewire.school.modals.form-scolary-year')
    </div>
</div>
