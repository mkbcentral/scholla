<div>
    <div class="d-flex justify-content-end">
       <div>
            @if (Auth::user()->roles->pluck('name')->contains('Admin'))
                <x-button
                    type="button"
                    class="btn btn-primary"
                    data-toggle="modal"
                    data-target="#formEtatBesoinModal">
                   Nouveau état des besoins
                </x-button>
            @endif
       </div>
    </div>
    <div>
        @php
            $total=0;
        @endphp
        <hr>
        <div>
            <div class="d-flex justify-content-between align-items-center mr-4">
                <div>
                    <div class="form-group">
                        <x-label value="{{ __('Filtrer par date') }}" />
                        <x-input class="" type='date'
                                 placeholder="Date" wire:model='date_to_search'/>
                    </div>
                </div>
                <div class="d-flex justify-content-end align-items-center mr-4">
                    <div class="form-group pr-4">
                        <x-label value="{{ __('Filtrer par moi') }}" />
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
                </div>
            </div>
        </div>
        @if ($etatBesoins->isEmpty())
            <h4 class="text-success text-center">Aucune dépense trouvée!</h4>
        @else
        <div class="d-flex justify-content-between align-items-center mr-4 mt-2">
            <div>     <h4>LISTE DES ETATT DE BESOIN</h4></div>
            <div>
                @if ($isDaySorted==true)
                <a target="_blank" class="btn btn-sm btn-info" href="{{ route('etatBesoin.day.print',$date_to_search) }}">
                    &#x1F5A8;Impriler/jour</a>
                @elseif ($this->itmePeriodSorted > 0)
                    <a target="_blank" class="btn btn-sm btn-danger"
                     href="{{ route('etatBesoin.periode.print',$itmePeriodSorted) }}">
                        &#x1F5A8;Impriler/periode</a>
                @elseif ($this->isMonthSorted == true)
                    <a target="_blank" class="btn btn-sm btn-primary" href="{{ route('etatBesoin.month.print',$month) }}">
                        &#x1F5A8;Impriler/mois</a>
                @endif
                <a target="_blank" class="btn btn-sm btn-secondary"
                    href="{{ route('etatBesoin.not.active.print',$month) }}">
                    &#x1F5A8;Non servi</a>
            </div>
        </div>
            <table class="table table-stripped table-sm mt-2">
                <thead class="thead-light">
                    <tr>
                        <th>N°</th>
                        <th>DATE</th>
                        <th>INTITULE</th>
                        <th class="text-right">MONTANT</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-center">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($etatBesoins as $index => $etatBesoin)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$etatBesoin->created_at->format('d/m/Y')}}</td>
                            <td>{{$etatBesoin->title}}</td>
                            <td class="text-right">{{number_format($etatBesoin->amount,1,',',' ') }}</td>
                            <td class="text-center">
                                @if ($etatBesoin->active==true)
                                    <span class="text-success">Repondu</span>
                                @else
                                    <span class="text-warning">Non Repondu</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if (Auth::user()->roles->pluck('name')->contains('Admin'))
                                    <x-button wire:click.prevent='showDeleteDialog({{$etatBesoin}})'
                                        class="text-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i>
                                    </x-button>
                                    <x-button data-toggle="modal"
                                    data-target="#editFormEtatBesoinModal"
                                        wire:click.prevent='edit({{$etatBesoin}})'
                                        class="text-primary btn-sm">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                    </x-button>
                                    <x-button data-toggle="modal"
                                        wire:click.prevent='activeetatBesoin({{$etatBesoin}})'
                                        class="text-info btn-sm">
                                        <i class=" {{$etatBesoin->active==false?'fa fa-check':'fas fa-times-circle'}} " aria-hidden="true"></i>
                                    </x-button>
                                @else

                                    <span>Ok !</span>
                                @endif

                            </td>
                        </tr>
                        @php
                            if($etatBesoin->active==true){
                                $total+=$etatBesoin->amount;
                            }
                        @endphp
                    @endforeach
                </tbody>
            </table>
            <div class="card ">
                <div class="card-body d-flex justify-content-end ">
                    <h3 class="text-right">Total: {{number_format($total,1,',',' ')}} Fc</h3>
                </div>
            </div>
        @endif
        @include('livewire.depense.modals.etatBesoin-form')
        @include('livewire.depense.modals.etatBesoin-edit-form')
    </div>
</div>
