<div>
    <x-loading-indicator />
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="text-uppercase text-primary">&#x1F5C2; Rapport périodique de paiement des inscriptions</h4>
                </div>
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
                <div class="form-group">
                    <x-label value="{{ __('Filtrer par période') }}" />
                    <x-select wire:model='periode'>
                        <option value="">Choisir</option>
                        @foreach ($itemsPeriodeFilter as $periode)
                            <option value="{{$periode}}">{{$periode}}</option>
                        @endforeach
                    </x-select>
                </div>
                <div class="form-group pr-4">
                    <x-label value="{{ __('Filtrer par classe') }}" />
                    <x-select wire:model='classe_id'>
                        <option value="0">Choisir...</option>
                        @foreach ($classes as $classe)
                            <option  value="{{$classe->id}}">{{$classe->name.'/'.$classe->option->name}}</option>
                        @endforeach
                    </x-select>
                </div>
                <div class="form-group pr-4">
                    <x-label value="{{ __('Filtrer par type inscription') }}" />
                    <x-select wire:model='cost_id'>
                        <option value="0">Choisir...</option>
                        @foreach ($costs as $cost)
                            <option value="{{$cost->id}}">{{$cost->name}}</option>
                        @endforeach
                    </x-select>
                </div>

            </div>
        </div>
        <div></div>
        <div>
            @if ($isMonthSorted==true)
                <a  target="_blank"
                    class="btn btn-danger" href="{{ route('inscription.paiement.month.print',$month) }}">
                    &#x1F5A8; Imprimer
                </a>
            @else
                <a  target="_blank"
                    class="btn btn-secondary" href="{{ route('inscription.paiement.periode.print',$itmePeriodSorted) }}">
                    &#x1F5A8; Imprimer
                </a>
            @endif
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mr-4">
        <div><h4 class="text-uppercase text-bold text-secondary mt-4">Liste Paiements</h4></div>
        <div class="w-25">
        <div class="card-tools">
            <div class="input-group input-group-sm">
              <input wire:model.debounce.500ms='keySearch' type="text" class="form-control" placeholder="Recheche ici...">
              <div class="input-group-append">
                <div class="btn btn-primary">
                  <i class="fas fa-search"></i>
                </div>
              </div>
            </div>
          </div>
    </div>
    </div>
    @if ($inscriptions->isEmpty())
    <h4 class="text-success text-center p-4">Aucune inscription trouvée !</h4>
    @else
        <table class="table table-stripped table-sm mt-4">
            <thead class="thead-light">
                <tr class="text-uppercase text-bold">
                    <th class="text-center">N°</th>
                    <th>Date</th>
                    <th class="">Eleve</th>
                    <th class="text-center">Classe</th>
                    <th class="text-right">Type</th>
                    <th class="text-right">Montant FC</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inscriptions as $index=> $inscription)
                    <tr>
                        <td class="text-center">{{$index+1}}</td>
                        <td class="text-primary">{{$inscription->created_at->format('d/m/Y')}}</td>
                        <td>{{$inscription->student->name}}</td>
                        <td class="text-center">{{$inscription->student->classe->name.'/'.$inscription->student->classe->option->name}}</td>
                        <td class="text-right">{{$inscription->cost->name}}</td>
                        <td class="text-right bg-secondary">
                            @if ($inscription->is_paied==false)
                                <span class="text-danger">Non validé</span>
                            @else
                                {{number_format($inscription->cost->amount*$taux,1,',',' ')}}
                            @endif
                        </td>
                    </tr>
                    @if ($inscription->is_paied==false)
                        @php
                        $total+=0;
                        @endphp
                    @else
                        @php
                        $total+=$inscription->cost->amount;
                        @endphp
                    @endif
                @endforeach
            </tbody>
        </table>
        <div class="card ">
            <div class="card-body d-flex justify-content-end ">
            <div class="w-25">
                    <table class="table table-stripped">
                        <tbody>
                            <tr>
                                <td style="font-size: 32px" class="text-right">Total:</td>
                            </tr>
                            <tr class="text-bold text-right">
                                <td style="font-size: 32px">{{number_format($total*$taux,1,',',' ')}} Fc</td>
                            </tr>
                        </tbody>
                    </table>
            </div>
            </div>
        </div>
    @endif
</div>
