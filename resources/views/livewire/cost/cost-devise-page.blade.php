<div>
    <x-loading-indicator />
    <div>
        <div class="d-flex justify-content-between">
            <div><h4 class="text-uppercase text-bold text-primary">Liste devise</h4></div>
            <div class="form-group">
                <label for="my-select">Année scolaire</label>
                  <div class="input-group date"  >
                    <select id="my-select" class="form-control" wire:model.defer='scolary_id'>
                        <option >Choisir...</option>
                        @foreach ($scolaryyears as $year)
                            <option wire:click.prevent='changeScolaryid' value="{{$year->id}}">{{$year->name}}</option>
                        @endforeach
                    </select>
                      <div class="input-group-append" >
                            <button wire:click='changeScolaryid' class="btn btn-info" type="button"><i class="fa fa-search"></i></button>
                      </div>
                  </div>
              </div>
            <div>
                <x-button wire:click.prevent='resetFormState' class="btn-info" type="button" data-toggle="modal" data-target="#formDeviseModal">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    Créer un nouvelle devise
                </x-button
            ></div>
        </div>
        @if ($devises->isEmpty())
            <h4 class="text-success text-center p-4">Aucune donnée trouvée !</h4>
        @else
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
        @endif

    </div>
    @include('livewire.cost.modals.form-cost-devise')
</div>
