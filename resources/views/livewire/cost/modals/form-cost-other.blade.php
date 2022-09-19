  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="formCostotherModal" tabindex="-1" role="dialog" aria-labelledby="formCostotherModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formCostotherModalLabel">{{$isEditable==false?'CREATION NOUVEAU FRAIS':
            'MISE A JOUR DU FRAIS'}}</h5>
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
                    <x-label value="{{ __('Nom du frais') }}" />
                    <x-input class="" type='text'
                             placeholder="Nom du farsi" wire:model.defer='state.name'/>
                    @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <x-label value="{{ __('Montant') }}" />
                    <x-input class="" type='number'
                             placeholder="Montant" wire:model.defer='state.amount'/>
                    @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="my-select">Type du frais</label>
                    <select id="my-select" class="form-control" wire:model.defer='state.type_other_cost_id'>
                        <option>Choisir...</option>
                        @foreach ($types as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                    @error('type_other_cost_id') <span class="error text-danger">{{ $message }}</span> @enderror
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
