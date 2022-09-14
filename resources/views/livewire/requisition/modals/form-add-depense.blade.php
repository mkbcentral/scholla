  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="formAddDetailModal" tabindex="-1" role="dialog" aria-labelledby="formAddDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formAddDetailModalLabel">AJOUTER UN DETAIL</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form
                wire:submit.prevent='addDetail'
            >
            <div class="modal-body">
                <div class="form-group">
                    <x-label value="{{ __('Description') }}" />
                    <textarea class="form-control" name="" id="" cols="3" rows="3"
                        wire:model.defer='description'>
                    </textarea>
                    @error('description') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <x-label value="{{ __('Montant') }}" />
                    <x-input class=""
                             placeholder="Montant" wire:model.defer='amount'/>
                    @error('amount') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="modal-footer">
                <x-button type="submit" class="btn btn-primary">Sauvegarder</x-button>
                <x-button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</x-button>
            </div>
        </form>
      </div>
    </div>
  </div>
