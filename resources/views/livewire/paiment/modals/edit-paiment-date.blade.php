  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="editPaiementDateModal" tabindex="-1" role="dialog" aria-labelledby="editPaiementDateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editPaiementDateModalLabel"> MISE A JOUR DE LA DATE DE PAIEMENT</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form  wire:submit.prevent='update'>
            <div class="modal-body">
                <div class="form-group">
                    <x-label value="{{ __('Date paiement') }}" />
                    <x-input class="" type="date"
                              wire:model.defer='paiment_date'/>
                    @error('paiment_date') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group pr-4">
                    <x-label value="{{ __('Mois') }}" />
                    <x-select wire:model='month_to_edit'>
                        <option value="">Choisir</option>
                        @foreach ($months as $m)
                            <option value="{{$m}}">{{strftime('%B', mktime(0, 0, 0, $m,10))}}</option>
                        @endforeach
                    </x-select>
                </div>
            </div>

            <div class="modal-footer">
                <x-button type="submit" class="btn btn-info" >Mettre à jour</x-button>
                <x-button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</x-button>
            </div>
        </form>
      </div>
    </div>
  </div>
