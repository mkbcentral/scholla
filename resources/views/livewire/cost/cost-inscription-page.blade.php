<div>
    <x-loading-indicator />
    <div>
        <div class="d-flex justify-content-between">
            <div><h4 class="text-uppercase text-bold text-primary">Liste des frais d'inscription</h4></div>
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
                @if (Auth::user()->roles->pluck('name')->contains('Admin') or
                        Auth::user()->roles->pluck('name')->contains('root'))
                    <x-button wire:click.prevent='resetFormState' class="btn-info"
                    type="button" data-toggle="modal" data-target="#formCostModal">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        Créer un nouveau frais
                    </x-button>
                @endif

            </div>
        </div>
        @if ($costs->isEmpty())
            <h4 class="text-success text-center p-4">Aucune donnée trouvée !</h4>
        @else
            <table class="table table-stripped table-sm mt-4">
                <thead class="thead-light">
                    <tr class="text-uppercase">
                        <th>Frais</th>
                        <th class="text-center">Montant</th>
                        <th class="text-center">MT CDF</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($costs as $cost)
                        <tr>
                            <td>{{$cost->name}}</td>
                            <td class="text-center">{{$cost->amount}} USD</td>
                            <td class="text-center">{{number_format( $cost->amount*2000,1,',',' ')}} CDF</td>
                            <td class="text-center ">
                                @if (Auth::user()->roles->pluck('name')->contains('Admin') or
                                    Auth::user()->roles->pluck('name')->contains('root'))
                                    <x-button class="btn-sm" data-toggle="modal" data-target="#formCostModal"
                                    type='button' wire:click.prevent='edit({{$cost}})'
                                    class="text-primary"><i class="fas fa-edit"></i></x-button>
                            <x-button wire:click.prevent='showDeleteDialog({{$cost}})' class="text-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></x-button>
                                @else
                                    <span>Ok</span>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        @include('livewire.cost.modals.form-cost')
    </div>
</div>
