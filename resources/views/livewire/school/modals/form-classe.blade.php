  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="formclasseModal" tabindex="-1" role="dialog" aria-labelledby="formclasseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formclasseModalLabel">{{$isEditable==false?'CREATION NOUVELLE CLASSE':
            'MISE A JOUR DE LA CLASSE'}}</h5>
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
                    <x-label value="{{ __('Nom de la classe') }}" />
                    <x-input class=""
                             placeholder="Nom de la classe" wire:model.defer='state.name'/>
                    @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <x-label value="{{ __('Option') }}" />
                    <x-select wire:model='state.classe_option_id'>
                        <option value="">Choisir...</option>
                        @foreach ($options as $option)
                            <option value="{{$option->id}}">{{$option->name}}</option>
                        @endforeach
                    </x-select>
                    @error('classe_option_id') <span class="error text-danger">{{ $message }}</span> @enderror
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
