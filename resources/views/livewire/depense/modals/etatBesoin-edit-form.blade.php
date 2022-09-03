  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="editFormEtatBesoinModal" tabindex="-1" role="dialog" aria-labelledby="editFormEtatBesoinModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editFormEtatBesoinModalLabel">MISE A JOUR DEPSNE</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form
            wire:submit.prevent='update'>
            <div class="modal-body">
                <div class="form-group">
                    <x-label value="{{ __('Motif de la dépense') }}" />
                    <x-input class="" type='text'
                             placeholder="Motif" wire:model.defer='title'/>
                    @error('title') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <x-label value="{{ __('Montant') }}" />
                    <x-input class="" type='text'
                             placeholder="Montant" wire:model.defer='amount'/>
                    @error('amount') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
                 <div class="form-group">
                    <x-label value="{{ __('Emise par') }}" />
                    <x-input class="" type='text'
                             placeholder="Emise par" wire:model.defer='emise_by'/>
                    @error('emise_by') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <textarea class="form-control" name="" id="" cols="3" rows="3"
                        wire:model.defer='description'>
                    </textarea>
                    @error('description') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="modal-footer">
                <x-button type="submit" class="btn btn-primary">Valider</x-button>
            </div>
        </form>
      </div>
    </div>
  </div>
