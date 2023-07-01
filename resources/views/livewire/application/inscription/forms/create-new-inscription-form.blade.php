<div>
      <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="formInscriptionModal" tabindex="-1" role="dialog" aria-labelledby="formInscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formInscriptionModalLabel">PASSER UNE NOUVELLE INSCRIPTION</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form
            wire:submit.prevent='store'>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-label value="{{ __('Nom complet élève') }}" />
                            <x-input class="" type='text'
                                     placeholder="Nom de la section" wire:model.defer='name'/>
                            @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-label value="{{ __('Date de naisaance') }}" />
                            <x-input class="" type='date'
                                     placeholder="Nom de la section" wire:model.defer='date_of_birth'/>
                            @error('date_of_birth') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-label value="{{ __('Genre') }}" />
                            <x-select wire:model.defer='gender'>
                                <option value="">Choisir...</option>
                                <option value="M">M</option>
                                <option value="F">F</option>
                            </x-select>
                        </div>
                        @error('gender') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-label value="{{ __('Classe') }}" />
                            <x-select wire:model.defer='classe_id'>
                                <option value="">Choisir...</option>
                                @foreach ($classeList as $classe)
                                    <option value="{{$classe->id}}">{{$classe->name.'/'.$classe->option->name}}</option>
                                @endforeach
                            </x-select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-label value="{{ __('Type inscription') }}" />
                            <x-select wire:model.defer='cost_inscription_id '>
                                <option value="">Choisir...</option>
                                @foreach ($costInscriptionList as $cost)
                                    <option value="{{$cost->id}}">{{$cost->name}}</option>
                                @endforeach
                            </x-select>
                        </div>
                    </div>
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

</div>
