  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="formPaiementListingModal" tabindex="-1" role="dialog" aria-labelledby="formPaiementListingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formPaiementListingModalLabel">PASSER PAIEMENT AUTRES FRAIS</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form
            wire:submit.prevent='validatePaiement'>
            <div class="modal-body">
                <div class="form-group">
                    <x-label value="{{ __('Type frais') }}" />
                    <x-select wire:model='cost_id'>
                        <option value="">Choisir...</option>
                        @foreach ($costs as $cost)
                            <option wire:click.prevent='getCost({{$cost->id}})' value="{{$cost->id}}">{{$cost->name}}</option>
                        @endforeach
                    </x-select>
                    @error('cost_id') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <x-label value="{{ __('Mois') }}" />
                    <x-select wire:model='month_name' >
                        <option value="">Choisir...</option>
                        @foreach ($months as $m)
                            <option  value="{{$m}}">{{strftime('%B', mktime(0, 0, 0, $m))}}</option>
                        @endforeach
                    </x-select>
                    @error('month_name') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
                <div>
                    <h3>Prix: {{number_format($cost_price,1,',',' ') }} Fc</h3>
                </div>
            </div>

            <div class="modal-footer">
                <x-button type="submit" class="btn btn-primary">Valider</x-button>
            </div>
        </form>
        <a target="_blank"
                href="{{ route('print.paiement.cost', [$cost_id,$month_name,$option_id,$isc_id]) }}"
                  class="btn btn-danger">Valider</a>

      </div>
    </div>
  </div>
