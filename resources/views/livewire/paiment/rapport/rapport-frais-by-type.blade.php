<div>
    <x-loading-indicator />
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div><h4 class="text-uppercase text-primary">&#x1F5C2; Rapport périodique de paiement frais {{$typeData->name}}</h4></div>
                <div>
                    <div class="form-group">
                        <label for="my-select">Anné scolaire</label>
                          <div class="input-group date"  >
                            <select id="my-select" class="form-control" wire:model.defer='scolary_id'>
                                <option >Choisir...</option>
                                @foreach ($scolaryyears as $year)
                                    <option wire:click.prevent='changeScolaryid' value="{{$year->id}}">{{$year->name}}</option>
                                @endforeach
                            </select>
                              <div class="input-group-append" >
                                    <button wire:click='changeScolaryid' class="btn btn-info" type="button"><i class="fa fa-search"></i></button>
                              </div>
                          </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
    @php
    $total=0;
    @endphp
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <div class="d-flex justify-content-between align-items-center mr-4">
                <div class="form-group pr-4">
                    <x-label value="{{ __('Filtrer par mois') }}" />
                    <x-select wire:model='month'>
                        @foreach ($months as $m)
                            <option value="{{$m}}">{{strftime('%B', mktime(0, 0, 0, $m))}}</option>
                        @endforeach
                    </x-select>
                </div>
                <div class="form-group pr-4">
                    <x-label value="{{ __('Filtrer par période') }}" />
                    <x-select wire:model='periode'>
                        <option value="">Choisir</option>
                        @foreach ($itemsPeriodeFilter as $periode)
                            <option value="{{$periode}}">{{$periode}}</option>
                        @endforeach
                    </x-select>
                </div>
                <div>
                    <div class="form-group">
                        <x-label value="{{ __('Filtrer par date') }}" />
                        <x-input class="" type='date'
                                 placeholder="Date" wire:model='date_to_search'/>
                    </div>
                </div>
            </div>
        </div>
        <div></div>
        <div>
            @if ($isMonthSorted==true)
                <a  target="_blank"
                    class="btn btn-danger"
                    href="{{ route('paiement.frais.month.print',
                    [$month,$cost_id,$type,$classe_id,$defaultScolaryYer->id]) }}"
                   >
                   &#x1F5A8; Imprimer
                </a>
            @elseif ($itmePeriodSorted>0)
                <a  target="_blank"
                    class="btn btn-secondary" href="{{ route('paiement.frais.periode.print',
                    [$itmePeriodSorted,$cost_id,$month,$type,$classe_id,$defaultScolaryYer->id]) }}">
                    &#x1F5A8; Imprimer
                </a>
            @elseif ($isDaySorted==true)
                <a  target="_blank"
                    class="btn btn-secondary" href="{{ route('paiement.frais.day.print',
                    [$date_to_search,$cost_id,$month,$type,$classe_id,$defaultScolaryYer->id]) }}">
                    &#x1F5A8; Imprimer
                </a>
            @endif
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mr-4">
        <div><h4 class="text-uppercase text-bold text-secondary mt-4">Liste Paiements</h4></div>
        <div class="w-25 mt-4">
            <div class="card-tools">
                <div class="input-group input-group-sm">
                  <input wire:model.debounce.500ms='keySearch' type="text"
                  class="form-control" placeholder="Recheche ici...">
                  <div class="input-group-append">
                    <div class="btn btn-primary">
                      <i class="fas fa-search"></i>
                    </div>
                  </div>
                </div>
              </div>
        </div>
        <div class="d-flex justify-content-end">
            <div class="form-group pr-4">
                <x-label value="{{ __('Filtrer par type frais') }}" />
                <x-select wire:model='cost_id'>
                    <option value="0">Choisir...</option>
                    @foreach ($costs as $cost)
                        <option value="{{$cost->id}}">{{$cost->name}}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="form-group pr-4">
                <x-label value="{{ __('Filtrer par classe') }}" />
                <x-select wire:model='classe_id'>
                    <option value="0">Choisir...</option>
                    @foreach ($classes as $classe)
                        <option value="{{$classe->id}}">{{$classe->name.'/'.$classe->option->name}}</option>
                    @endforeach
                </x-select>
            </div>
        </div>
    </div>
    @if ($paiments->isEmpty())
        <h4 class="text-success text-center p-4">Aucun paiment trouvé !</h4>
    @else
        <table class="table table-sm table-light">
            <thead class="thead-light">
                <tr>
                    <th>N°</th>
                    <th>DATE</th>
                    <th>CODE</th>
                    <th>ELEVE</th>
                    <th>TYPE</th>
                    <th class="text-right">MONTANT</th>
                    <th class="text-center">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paiments as $index=> $paiment)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td class="text-primary">
                            <a href="#" data-toggle="modal"
                              data-target="#editPaiementDateModal" wire:click.prevent='edit({{$paiment}})'>
                            {{$paiment->created_at->format('d/m/Y')}}
                            </a>
                        </td>
                        <td>
                            <a href="" data-toggle="modal"
                                data-target="#editPaiementNumberModal" wire:click.prevent='edit({{$paiment}})'>
                                {{$paiment->number_paiement}}</td>
                            </a>
                        <td>{{$paiment->student->name.'/'.$paiment->student->classe->name.'/'.$paiment->student->classe->option->name}}</td>
                        <td>{{$paiment->cost->name }}</td>
                        <td class="text-right">{{number_format($paiment->cost->amount*$taux,1,',',' ') }}</td>
                        <td class="text-center">
                            @if (Auth::user()->roles->pluck('name')->contains('Finance'))
                                <a target="_blank" href="{{ route('recu.frais.print',$paiment->id) }}"
                                         class="btn btn-sm btn-primary">&#x1F5A8;
                                </a>
                                <button class="btn btn-sm btn-danger"  wire:click.prevent='showDeleteDialog({{$paiment}})'>
                                            Retirer
                                </button>

                            @else
                                <span>Ok !</span>
                            @endif

                        </td>

                    </tr>
                    @php
                        $total+=$paiment->cost->amount;
                    @endphp
                @endforeach
            </tbody>
        </table>
        <div class="card ">
            <div class="card-body d-flex justify-content-end ">
                <h3 class="text-right">Total: {{number_format($total*$taux,1,',',' ')}} Fc</h3>
            </div>
        </div>
    @endif
        @include('livewire.paiment.modals.edit-paiment-date')
        @include('livewire.paiment.modals.edit-paiment-number')
</div>
