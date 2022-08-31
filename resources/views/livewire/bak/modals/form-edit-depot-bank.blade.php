  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="formEditDepotBankModal" tabindex="-1" role="dialog" aria-labelledby="formEditDepotBankModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formEditDepotBankModalLabel">Modifier un dépôt à la banque</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form
            wire:submit.prevent='update'>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-label value="{{ __('Intitulé') }}" />
                            <x-input class="" type='text'
                                     placeholder="Intitulé" wire:model.defer='title'/>
                            @error('title') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-label value="{{ __('Du: '.$labelTo) }}" />
                            <x-input class="" type='date'
                                     placeholder="Du" wire:model.defer='dateTo'/>
                            @error('dateTo') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-label value="{{ __('Au: '.$labelFrom) }}" />
                            <x-input class="" type='date'
                                     placeholder="Montant" wire:model.defer='dateFrom'/>
                            @error('dateFrom') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="my-select">Devise</label>
                            <select id="my-select" class="form-control" wire:model.defer='devise'>
                                @if ($depotToEdit != null)
                                <option value="{{$depotToEdit->devise}}">{{$depotToEdit->devise}}</option>
                                @endif
                                <option value="CDF">CDF</option>
                                <option value="USD">USD</option>
                            </select>
                            @error('devise') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-label value="{{ __('Montant') }}" />
                            <x-input class="" type='text'
                                     placeholder="Montant" wire:model.defer='amount'/>
                            @error('amount') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-label value="{{ __('Observation') }}" />
                            <textarea class="form-control" name="" id="" cols="3" rows="3"
                                wire:model.defer='observation'>
                            </textarea>
                            @error('description') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <x-button type="submit" class="btn btn-primary">Valider</x-button>
            </div>
        </form>
      </div>
    </div>
  </div>
