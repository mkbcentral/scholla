  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="addSortieFraisEtatModal" tabindex="-1" role="dialog"
      aria-labelledby="addSortieFraisEtatModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="addSortieFraisEtatModalLabel"> REALISER SORTIE BANK</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form wire:submit.prevent='executeSortie'>
                  <div class="modal-body">
                      <div class="form-group">
                          <x-label value="{{ __('Montant') }}" />
                          <x-input class="" type="number" wire:model.defer='amount_sortie' />
                          @error('amount_sortie')
                              <span class="error text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                      <div class="form-group">
                          <x-label value="{{ __('Date') }}" />
                          <x-input class="" type="date" wire:model.defer='executed_at' />
                          @error('executed_at')
                              <span class="error text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                      <x-button type="submit" class="btn btn-primary">Executer</x-button>
                      <x-button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</x-button>
                  </div>
              </form>
          </div>
      </div>
  </div>
