<div>
    <x-loading-indicator />
    <div class="card">
        <div class="card-body">
            <h4 class="text-uppercase text-primary">&#x1F5C2; Rapport périodique de paiement des inscriptions</h4>
        </div>
    </div>
    @php
        $total=0;
        $total_fonctionnement=0;
        $total_bank=0;
        $total_depense=0;
    @endphp
    <div class="d-flex justify-content-between align-items-center">
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
                class="btn btn-danger" href="{{ route('inscription.paiement.all.print',[$isFilted,$dateTo,$dateFrom]) }} ">
                    &#x1F5A8; Imprimer
            </a>
            <button  class="btn btn-primary" type="button" wire:click.prrevent='refreshData'>Actualiser</button>
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
    <table class="table table-stripped table-sm mt-4">
        <thead class="thead-light">
            <tr class="text-uppercase text-bold">
                <th class="text-center">
                    <div class="icheck-primary d-inline">
                        <input wire:model='selectPageRows' type="checkbox" id="checkboxPrimary2">
                        <label for="checkboxPrimary2"></label>
                    </div>
                </th>
                <th class="text-center">N°</th>
                <th>Date</th>
                <th class="">Eleve</th>
                <th class="text-center">Classe</th>
                <th class="text-right">Type</th>
                <th class="text-right">Montant FC</th>
                <td>Actions</td>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inscriptions as $index=> $inscription)

                <tr class="
                    @if ($inscription->is_bank==true)
                        bg-success
                        text-white
                    @elseif ($inscription->is_fonctionnement==true)
                        bg-info
                        text-white
                    @elseif ($inscription->is_depense==true)
                        bg-danger
                        text-white
                    @else

                    @endif
                    ">
                    <th>
                        <div class="icheck-primary d-inline ml-2">
                            <input wire:model="selectedRows"
                                value="{{$inscription->id}}" type="checkbox" id="{{$inscription->id}}">
                            <label for="{{$inscription->id}}"></label>
                        </div>
                    </th>
                    <td class="text-center">{{$index+1}}</td>
                    <td class="

                        @if ($inscription->is_bank==true)

                            text-white
                        @elseif ($inscription->is_fonctionnement==true)

                            text-white
                        @elseif ($inscription->is_depense==true)

                            text-white
                        @else
                        text-primary
                        @endif
                        ">
                            {{$inscription->created_at->format('d/m/Y')}}ù
                    </td>
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
                   <td>
                    <button class="btn btn-sm btn-danger"
                        wire:click.prevent='showDeleteDialog({{$inscription}},{{$inscription->student}})'>
                        Ratirer
                    </button>
                   </td>
                </tr>
                @if ($inscription->is_paied==false)
                    @php
                    $total+=0;
                    @endphp
                @else
                    @php
                        if ($inscription->is_bank==true){
                            $total_bank+=$inscription->cost->amount;
                        }

                        elseif ($inscription->is_fonctionnement==true)
                           {
                            $total_fonctionnement+=$inscription->cost->amount;
                           }
                        elseif ($inscription->is_depense==true)
                            {
                                $total_depense+=$inscription->cost->amount;
                            }
                        else
                            {
                                $total+=$inscription->cost->amount;
                            }

                    @endphp
                @endif
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
                            <td>{{number_format($total*$taux,1,',',' ')}} Fc</td>
                            <td class="text-success">{{number_format($total_bank*$taux,1,',',' ')}} Fc</td>
                            <td class="text-info">{{number_format($total_fonctionnement*$taux,1,',',' ')}} Fc</td>
                            <td class="text-danger">{{number_format($total_depense*$taux,1,',',' ')}} FC</td>
                            <td class="bg-dark text-right">{{number_format(($total*$taux)-($total_bank*$taux)-($total_depense*$taux)-($total_fonctionnement*$taux),1,',',' ')}} Fc</td>

                        </tr>
                    </tbody>
                </table>
           </div>
        </div>
    </div>
</div>
