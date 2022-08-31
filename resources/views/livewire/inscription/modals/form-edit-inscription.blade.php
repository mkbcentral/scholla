  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="formEditInscriptionModal" tabindex="-1" role="dialog" aria-labelledby="formEditInscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formEditInscriptionModalLabel">MISE A JOUR </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form
            wire:submit.prevent='update'>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-label value="{{ __('Nom complet élève') }}" />
                            <x-input class="" type='text'
                                     placeholder="Nom de la section" wire:model.defer='state.name'/>
                            @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-label value="{{ __('Date de naisaance: '.$label_date) }}" />
                            <x-input class="" type='date'
                                     placeholder="Nom de la section" wire:model.defer='state.date_of_birth'/>
                            @error('date_of_birth') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-label value="{{ __('Genre') }}" />
                            <x-select wire:model='state.gender'>
                                <option value="">Choisir...</option>
                                <option value="M">M</option>
                                <option value="F">F</option>
                            </x-select>
                        </div>
                        @error('gender') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-label value="{{ __('Lieu de naissance') }}" />
                            <x-input class="" type='text'
                                     placeholder="Lieu de naissance" wire:model.defer='state.place_of_birth'/>
                            @error('place_of_birth') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-label value="{{ __('Classe') }}" />
                            <x-select wire:model='state.classe_id'>
                                <option value="">Choisir...</option>
                                @foreach ($classesToEdit as $classe)
                                    <option value="{{$classe->id}}">{{$classe->name.'/'.$classe->option->name}}</option>
                                @endforeach
                            </x-select>
                            @error('classe_id') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-label value="{{ __('Type inscription') }}" />
                            <x-select wire:model='state.cost_inscription_id'>
                                <option value="">Choisir...</option>
                                @foreach ($costs as $cost)
                                    <option value="{{$cost->id}}">{{$cost->name}}</option>
                                @endforeach
                            </x-select>
                            @error('cost_inscription_id') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-label value="{{ __('Nom du responsable') }}" />
                            <x-input class="" type='text'
                                     placeholder="Nom du responsable" wire:model.defer='state.name_responsable'/>
                            @error('name_responsable') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-label value="{{ __('Téléphone') }}" />
                            <x-input class="" type='text'
                                     placeholder="Tél" wire:model.defer='state.phone'/>
                            @error('phone') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-label value="{{ __('Autre Tél') }}" />
                            <x-input class="" type='text'
                                     placeholder="Autre tél" wire:model.defer='state.other_phone'/>
                            @error('other_phone') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-label value="{{ __('Adresse email') }}" />
                            <x-input class="" type='text'
                                     placeholder="Nom de la section" wire:model.defer='state.email'/>
                            @error('email') <span class="error text-danger">{{ $message }}</span> @enderror
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
