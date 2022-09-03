<div>
    <div class="d-flex justify-content-start">
       <div>
            @if (Auth::user()->roles->pluck('name')->contains('Admin'))
                <x-button
                    type="button"
                    class="btn btn-info"
                    data-toggle="modal"
                    data-target="#formDepenseModal">
                    Passer une nouvelle dépense
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
        @if ($depenses->isEmpty())
            <h4 class="text-success text-center">Aucune dépense trouvée!</h4>
        @else
        <div class="d-flex justify-content-between align-items-center mr-4 mt-2">
            <div>     <h4>LISTE DEPENSES</h4></div>
            <div>
                @if ($isDaySorted==true)
                <a target="_blank" class="btn btn-sm btn-info" href="{{ route('depense.day.print',$date_to_search) }}">
                    &#x1F5A8;Impriler/jour</a>
                @elseif ($this->itmePeriodSorted > 0)
                    <a target="_blank" class="btn btn-sm btn-danger"
                     href="{{ route('depense.periode.print',$itmePeriodSorted) }}">
                        &#x1F5A8;Impriler/periode</a>
                @elseif ($this->isMonthSorted == true)
                    <a target="_blank" class="btn btn-sm btn-primary" href="{{ route('depense.month.print',$month) }}">
                        &#x1F5A8;Impriler/mois</a>
                @endif
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
                    @foreach ($depenses as $index => $depense)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$depense->created_at->format('d/m/Y')}}</td>
                            <td>{{$depense->title}}</td>
                            <td class="text-right">{{number_format($depense->amount,1,',',' ') }}</td>
                            <td class="text-center">
                                @if ($depense->active==true)
                                    <span class="text-success">Validée</span>
                                @else
                                    <span class="text-danger">No validée</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if (Auth::user()->roles->pluck('name')->contains('Admin'))
                                    <x-button wire:click.prevent='showDeleteDialog({{$depense}})'
                                        class="text-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i>
                                    </x-button>
                                    <x-button data-toggle="modal"
                                    data-target="#editFormDepenseModal" wire:click.prevent='edit({{$depense}})'
                                        class="text-primary btn-sm">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                    </x-button>
                                    <x-button data-toggle="modal"
                                        wire:click.prevent='activeDepense({{$depense}})'
                                        class="text-info btn-sm">
                                        <i class=" {{$depense->active==false?'fa fa-check':'fas fa-times-circle'}} " aria-hidden="true"></i>
                                    </x-button>
                                @else

                                    <span>Ok !</span>
                                @endif

                            </td>
                        </tr>
                        @php
                            if($depense->active==true){
                                $total+=$depense->amount;
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
        @include('livewire.depense.modals.depense-form')
        @include('livewire.depense.modals.depense-edit-form')
    </div>
</div>
