  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="formReqModal" tabindex="-1" role="dialog" aria-labelledby="formReqModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formReqModalLabel">{{$isEditable==false?'CREATION  NOUVEL EMETTEUR REQ ':
            'MISE A JOUR EMETTEUR REQ.'}}</h5>
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
                    <x-label value="{{ __('Nom emeteur') }}" />
                    <div class="form-group">
                        <select id="my-select" class="form-control" wire:model.defer='state.emit_req_id'>
                            <option value="">Choisir...</option>
                            @foreach ($emitters as $emitter)
                                <option value="{{$emitter->id}}">{{$emitter->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('emit_req_id') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
                @if ($isEditable==true)
                    <div class="form-group">
                        <label for="my-input">Date</label>
                        <input id="my-input" class="form-control" type="date"  wire:model.defer='state.created_at'>
                    </div>
                    <div class="form-group">
                        <x-label value="{{ __('Source ') }}" />
                        <div class="form-group">
                            <select id="my-select" class="form-control" wire:model.defer='state.source_req_id'>
                                @foreach ($sources as $source)
                                    <option value="{{$source->id}}">{{$source->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('source_req_id') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                @endif

            </div>
            <div class="modal-footer">
                @if ($isEditable==false)
                    <x-button type="submit" class="btn btn-primary">Sauvegarder</x-button>
                @else
                    <x-button wire:click.prevent='update' type="submit" class="btn btn-info" >Mettre ?? jour</x-button>
                @endif
                <x-button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</x-button>
            </div>
        </form>
      </div>
    </div>
  </div>
