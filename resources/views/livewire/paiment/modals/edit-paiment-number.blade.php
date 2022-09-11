  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="editPaiementNumberModal" tabindex="-1" role="dialog" aria-labelledby="editPaiementNumberModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editPaiementNumberModalLabel"> MISE A JOUR DNUMERO DU PAIEMENT</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form  wire:submit.prevent='updateNumber'>
            <div class="modal-body">
                <div class="form-group">
                    <x-label value="{{ __('Numero') }}" />
                    <x-input class="" type="text"
                              wire:model.defer='number_paiment'/>
                    @error('number_paiment') <span class="error text-danger">{{ $message }}</span> @enderror
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
