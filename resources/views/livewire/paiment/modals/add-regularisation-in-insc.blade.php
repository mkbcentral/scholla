  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="addReqularisationModal" tabindex="-1" role="dialog" aria-labelledby="addReqularisationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addReqularisationModalLabel"> PASSER UNE REGULARISATION</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="p-2">
            <h5>Montant: {{$insc_amount*2000}} Fc</h5>
        </div>
        <form  wire:submit.prevent='addRegularisation'>
            <div class="modal-body">
                <div class="form-group">
                    <x-label value="{{ __('Montant utilisé') }}" />
                    <x-input class="" type="text"
                              wire:model.defer='amount_regularisation'/>
                    @error('amount_regularisation') <span class="error text-danger">{{ $message }}</span> @enderror
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
