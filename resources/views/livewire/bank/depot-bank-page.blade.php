<div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex justify-content-start align-items-center">
                    <div class="form-group pr-4">
                        <x-label value="{{ __('Filtrer par moi') }}" />
                        <x-select wire:model='month'>
                            @foreach ($months as $m)
                                <option value="{{$m}}">{{strftime('%B', mktime(0, 0, 0, $m))}}</option>
                            @endforeach
                        </x-select>
                    </div>
                    <div>
                        <a target="_blank" class="btn btn-primary"
                            href="{{ route('bank.depot.print', $month) }}">&#x1F5A8; Imprimer par mois</a>
                        <a target="_blank" class="btn btn-secondary"
                            href="{{ route('bank.depot.print.all') }}">&#x1F5A8; Imprimer tout</a>
                    </div>
                </div>
                <div>
                    <x-button
                        type="button"
                        class="btn btn-danger"
                        data-toggle="modal"
                        data-target="#formDepotBankModal">
                        &#x2795; Nouveau dépoôt banque
                    </x-button>
                </div>
            </div>
            @php
                $total=0;
            @endphp
            @if ($depots->isEmpty())
                <h3 class="text-center text-success">Aucun dépôt chargé &#x1FAB9;</h3>
            @else
            <div class="mt-4">
                <table class="table table-light">
                    <thead class="thead-light">
                        <tr class="text-uppercase">
                            <th>N°</th>
                            <th>INTITULE</th>
                            <th class="text-center">DU - AU</th>
                            <th class="text-right">MONTANT</th>
                            <th class="text-center">STATUS</th>
                            <th  class="text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($depots as $index => $depot)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$depot->title}}</td>
                                <td class="text-center">{{$depot->dateTo->format('d/m/Y').' - '.$depot->dateFrom->format('d/m/Y')}}</td>

                                <td class="text-right">{{$depot->devise.' '.number_format($depot->amount,1,',',' ') }}</td>
                                <td class="text-center">
                                    @if ($depot->active==true)
                                        <span class="text-success">Dépôsé !</span>
                                    @else
                                        <span class="text-danger">En cours...</span>
                                    @endif
                                </td>
                                <td  class="text-center">
                                    @if ($depot->active==false)
                                        <button wire:click.prenvent='activeDepot({{$depot}})' class="btn btn-sm btn-secondary" type="button">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        </button>
                                    @else
                                        <button wire:click.prenvent='activeDepot({{$depot}})' class="btn btn-sm btn-danger" type="button">
                                            &#x274C;
                                        </button>
                                    @endif

                                    <button
                                     wire:click.prevent='edit({{$depot}})' data-toggle="modal"
                                    data-target="#formEditDepotBankModal" class="btn btn-sm btn-info" type="button"><i class="fas fa-edit    "></i></button>
                                    <button wire:click.prevent='showDeleteDialog({{$depot}})' class="btn btn-sm btn-danger" type="button">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                            @php
                                if($depot->active==true){
                                    $total+=$depot->amount;
                                }
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
        <div class="card ">
            <div class="card-body d-flex justify-content-end ">
                <h3 class="text-right">Total: {{number_format($total,1,',',' ')}} Fc</h3>
            </div>
        </div>
    </div>
    @include('livewire.bank.modals.form-depot-bank')
    @include('livewire.bank.modals.form-edit-depot-bank')
</div>
