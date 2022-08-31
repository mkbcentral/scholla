  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="formsourceModal" tabindex="-1" role="dialog" aria-labelledby="formsourceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formsourceModalLabel">{{$isEditable==false?'CREATION NOUVELLE DEVISE':
            'MISE A JOUR DE LA DEVISE'}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form
            @if ($isEditable==false)
                wire:submit.prevent='store'
            @else
                wire:submit.prevent='update'
            @endif
            >
            <div class="modal-body">
                <div class="form-group">
                    <x-label value="{{ __('Libélé') }}" />
                    <x-input class="" type='text'
                             placeholder="Libelé" wire:model.defer='state.name'/>
                    @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <x-label value="{{ __('Solde') }}" />
                    <x-input class="" type='number'
                             placeholder="Solde" wire:model.defer='state.solde'/>
                    @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="modal-footer">
                @if ($isEditable==false)
                    <x-button type="submit" class="btn btn-primary">Sauvegarder</x-button>
                @else
                    <x-button wire:click.prevent='update' type="submit" class="btn btn-info" >Mettre à jour</x-button>
                @endif
                <x-button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</x-button>
            </div>
        </form>
      </div>
    </div>
  </div>
