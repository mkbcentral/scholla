  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="addSalaireModal" tabindex="-1" role="dialog" aria-labelledby="addSalaireModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addSalaireModalLabel"> Fixer le salaire</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group pr-4">
                <x-label value="{{ __('Sur quel mois') }}" />
                <x-select wire:model='month_name'>
                    <option value="">Choisir</option>
                    @foreach ($months as $m)
                        <option value="{{$m}}">{{strftime('%B', mktime(0, 0, 0, $m,10))}}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="form-group">
                <x-label value="{{ __('Montant') }}" />
                <x-input class="" type="text"
                          wire:model.defer='amount_salire'/>
                @error('amount_salire') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>

        </div>

        <div class="modal-footer">
            <x-button type="button" wire:click.prevent='addSalaire' class="btn btn-info" >Mettre à jour</x-button>
            <x-button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</x-button>
        </div>
      </div>
    </div>
  </div>
