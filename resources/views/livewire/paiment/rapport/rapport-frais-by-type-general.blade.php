<div>
    <x-loading-indicator />
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="text-uppercase text-primary">&#x1F5C2; Rapport annuels de paiement des frais {{$typeData->name}}</h4>
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
    $total_fonctionnement=0;
    $total_bank=0;
    $total_depense=0;
    @endphp
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <div class="d-flex justify-content-start align-items-center">
                <div class="form-group pr-2">
                    <x-label value="{{ __('Du') }}" />
                    <x-input class="" type='date'
                             placeholder="Lieu de naissance" wire:model='dateTo'/>

                </div>
                <div class="form-group pr-2"">
                    <x-label value="{{ __('Au') }}" />
                    <x-input class="" type='date'
                             placeholder="Lieu de naissance" wire:model='dateFrom'/>
                </div>

            </div>
        </div>
         <div>
            @if ($selectedRows != [])
            <div>
                    <span>{{count($selectedRows)}} élement selectionné(s)</span>
                </div>
                <div class="btn-group">

                    <button type="button" class="btn btn-info">Activer</button>
                    <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                    <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                        @if ($typeData->name=="Minerval")
                            <a class="dropdown-item" href="#" wire:click.prevent='markIsBank'>Marquer dépôt banque</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" wire:click.prevent='markIsFonctionnement'>Marquer fonctionnement</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" wire:click.prevent='markIsDepense'>Marquer depensé</a>
                        @else
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" wire:click.prevent='markIsFonctionnement'>Marquer fonctionnement</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" wire:click.prevent='markIsDepense'>Marquer depensé</a>
                        @endif

                    </div>
                </div>
                <div class="btn-group">

                <button type="button" class="btn btn-danger">Déactiver</button>
                    <button type="button" class="btn btn-danger dropdown-toggle dropdown-icon"
                     data-toggle="dropdown">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu" role="menu">
                    @if ($typeData->name=="Minerval")
                        <a class="dropdown-item" href="#" wire:click.prevent='desableIsBank'>Annuler dépôt banque</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" wire:click.prevent='desableIsFonctionnement'>Annuler fonctionnement</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" wire:click.prevent='desableIsDepense'>Annuler depensé</a>
                    @else
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" wire:click.prevent='desableIsFonctionnement'>Annuler fonctionnement</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" wire:click.prevent='desableIsDepense'>Annuler depensé</a>
                    @endif

                </div>
            </div>
           @endif
         </div>
        <div>
            <div class="btn-group">

                <button type="button" class="btn btn-danger">
                    &#x1F5A8; Imprimer
                </button>
                <button type="button" class="btn btn-danger dropdown-toggle dropdown-icon"
                     data-toggle="dropdown">
                <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu" role="menu" >
                    @foreach ($typeFilters as $item)
                        <a target="_blank" class="dropdown-item" href="{{ route('paiement.frais.global.print', [$item,$cost_id,$type,$classe_id]) }}" >{{$item}}</a>
                    @endforeach
                </div>
            </div>
        </a>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mr-4">
        <div><h4 class="text-uppercase text-bold text-secondary mt-4">Liste Paiements</h4></div>
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
                    <th class="text-center">
                        <div class="icheck-primary d-inline">
                            <input wire:model='selectPageRows' type="checkbox" id="checkboxPrimary2">
                            <label for="checkboxPrimary2"></label>
                        </div>
                    </th>
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
                    <tr
                       class="
                            @if ($paiment->is_bank==true)
                            bg-success
                            text-white
                        @elseif ($paiment->is_fonctionnement==true)
                            bg-info
                            text-white
                        @elseif ($paiment->is_depense==true)
                            bg-danger
                            text-white
                        @else

                        @endif
                            "
                        >
                        <th>
                            <div class="icheck-primary d-inline ml-2">
                                <input wire:model="selectedRows"
                                    value="{{$paiment->id}}" type="checkbox" id="{{$paiment->id}}">
                                <label for="{{$paiment->id}}"></label>
                            </div>
                        </th>
                        <td>{{$index+1}}</td>
                        <td class="
                            @if ($paiment->is_bank==true)
                                text-white
                            @elseif ($paiment->is_fonctionnement==true)

                                text-white
                            @elseif ($paiment->is_depense==true)

                                text-white
                            @else
                                text-primary
                            @endif
                            ">
                            {{$paiment->created_at->format('d/m/Y')}}
                        </td>
                        <td>{{$paiment->number_paiement}}</td>
                        <td>{{$paiment->student->name.'/'.$paiment->student->classe->name.'/'.$paiment->student->classe->option->name}}</td>
                        <td>{{$paiment->cost->name }}</td>
                        <td class="text-right">
                            @if ($paiment->depense)
                                <span class="bg-danger p-1">
                                   <a href="" data-toggle="modal"
                                        data-target="#showInDepensePaimentModal"
                                        wire:click.prevent='show({{$paiment}})'>
                                    {{number_format($paiment->cost->amount*$taux-$paiment->depense->amount,1,',',' ') }}
                                   </a>
                                </span>
                            @else
                                {{number_format($paiment->cost->amount*$taux)}}
                            @endif

                        </td>
                        <td class="text-center">
                            @if ($paiment->depense)
                                <button wire:click='deleteDepense({{$paiment->id}})'  class="btn btn-sm btn-danger" type="button">Annuler</button>
                            @else
                                <button data-toggle="modal"
                                    data-target="#addInDepensePaimentModal"
                                    wire:click.prevent='edit({{$paiment}})' class="btn btn-sm btn-primary" type="button">Marquer</button>
                             @endif
                        </td>

                    </tr>
                    @php
                        if ($paiment->depense) {
                                if ($paiment->is_bank==true){
                                $total_bank+=$paiment->cost->amount*2000-$paiment->depense->amount;
                            }

                            elseif ($paiment->is_fonctionnement==true)
                            {
                                $total_fonctionnement+=$paiment->cost->amount*2000-$paiment->depense->amount;
                            }
                            elseif ($paiment->is_depense==true)
                                {
                                    $total_depense+=$paiment->cost->amount*2000-$paiment->depense->amount;
                                }
                            $total+=$paiment->cost->amount*2000-$paiment->depense->amount;
                        } else {
                            if ($paiment->is_bank==true){
                                    $total_bank+=$paiment->cost->amount*2000;
                                }

                                elseif ($paiment->is_fonctionnement==true)
                                {
                                    $total_fonctionnement+=$paiment->cost->amount*2000;
                                }
                                elseif ($paiment->is_depense==true)
                                    {
                                        $total_depense+=$paiment->cost->amount*2000;
                                    }
                                $total+=$paiment->cost->amount*2000;
                        }


                    @endphp
                @endforeach
            </tbody>
        </table>
        <div class="card ">
            <div class="card-body d-flex justify-content-between ">
               <div class="w-100">
                    <h5 class="text-bold text-info">Situation globale</h5>
                    <table class="table table-stripped">
                        <tbody>
                            <tr class=" text-bold">
                                <td>Total:</td>
                                <td class="text-success">Dép. baque:</td>
                                <td class="text-info">Fonct.:</td>
                                <td class="text-danger">Autres dép.:</td>
                                <td class="bg-dark text-right">Solde</td>
                            </tr>
                            <tr class="text-bold">
                                <td>{{number_format($total,1,',',' ')}} Fc</td>
                                <td class="text-success">{{number_format($total_bank,1,',',' ')}} Fc</td>
                                <td class="text-info">{{number_format($total_fonctionnement,1,',',' ')}} Fc</td>
                                <td class="text-danger">{{number_format($total_depense,1,',',' ')}} FC</td>
                                <td class="bg-dark text-right">{{number_format($total-$total_bank-$total_depense-$total_fonctionnement,1,',',' ')}} Fc</td>
                            </tr>
                        </tbody>
                    </table>
               </div>
            </div>
        </div>
    @endif
    @include('livewire.paiment.modals.add-depense-in-paiement')
    @include('livewire.paiment.modals.show-depense-in-paiment')
</div>
