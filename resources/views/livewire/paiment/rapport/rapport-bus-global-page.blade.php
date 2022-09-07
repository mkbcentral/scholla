<div>
    <x-loading-indicator />
    <div class="card">
        <div class="card-body">
            <h4 class="text-uppercase text-primary">&#x1F5C2; Rapport golbal bus et autres frais</h4>
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
                        <a class="dropdown-item" href="#" wire:click.prevent='markIsBank'>Marquer dépôt banque</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" wire:click.prevent='markIsFonctionnement'>Marquer fonctionnement</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" wire:click.prevent='markIsDepense'>Marquer depensé</a>
                    </div>
                </div>
                <div class="btn-group">

                <button type="button" class="btn btn-danger">Déactiver</button>
                <button type="button" class="btn btn-danger dropdown-toggle dropdown-icon" data-toggle="dropdown">
                <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu" role="menu">
                    <a class="dropdown-item" href="#" wire:click.prevent='desableIsBank'>Annuler dépôt banque</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" wire:click.prevent='desableIsFonctionnement'>Annuler fonctionnement</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" wire:click.prevent='desableIsDepense'>Annuler depensé</a>
                </div>
            </div>
           @endif
         </div>
        <div>
            <a  target="_blank"
            class="btn btn-danger" href="">
            &#x1F5A8; Imprimer
        </a>
        </div>
    </div>
    @if ($paiments->isEmpty())
        <h4 class="text-success text-center p-4">Aucun paiment trouvé !</h4>
    @else
        <div class="d-flex justify-content-between align-items-center mr-4">
            <div><h4 class="text-uppercase text-bold text-secondary mt-4">Liste Paiements</h4></div>
            <div>
                <div class="form-group pr-4">
                    <x-label value="{{ __('Filtrer par type frais') }}" />
                    <x-select wire:model='cost_id'>
                        <option value="0">Choisir...</option>
                        @foreach ($costs as $cost)
                            <option value="{{$cost->id}}">{{$cost->name}}</option>
                        @endforeach
                    </x-select>
                </div>
            </div>
        </div>
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
                        <td>{{$paiment->cost->name.'/'.strftime('%B', mktime(0, 0, 0, $paiment->mounth_name)) }}</td>
                        <td class="text-right">{{number_format($paiment->cost->amount*$taux,1,',',' ') }}</td>
                        <td class="text-center">
                            @if (Auth::user()->roles->pluck('name')->contains('Finance'))
                                <a target="_blank" href="{{ route('recu.frais.print',$paiment->id) }}" class="btn btn-sm btn-primary">&#x1F5A8;</a>
                            @else
                                <span>Ok !</span>
                            @endif

                        </td>

                    </tr>
                    @php

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

</div>
