<div>
    <div class="card">
        <div class="card-body">
            <h4 class="text-uppercase text-primary">&#x1F4B8; Paiements journaliers</h4>
        </div>
    </div>
    @php
        $total=0;
    @endphp
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <div class="">
                <div class="form-group">
                    <x-label value="{{ __('Filtrer par date') }}" />
                    <x-input class="" type='date'
                             placeholder="Lieu de naissance" wire:model='date_to_search'/>
                    @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div></div>
        <div class="mr-4">
            @if (Auth::user()->roles->pluck('name')->contains('Finance'))
                <x-button
                    class="btn-primary" type="button" wire:click.prevent='refreshData'>
                    Actualiser
                </x-button>
                <a  target="_blank"
                    class="btn btn-danger" href="{{ route('inscription.paiement.day.print',$date_to_search) }}">
                    &#x1F5A8; Imprimer
                </a>
            @endif
            <a  target="_blank"
            class="btn btn-danger" href="{{ route('inscription.paiement.day.print',$date_to_search) }}">
            &#x1F5A8; Imprimer
        </a>

        </div>
    </div>
    <h4 class="text-uppercase text-bold text-secondary">Liste Paiements</h4>
    <table class="table table-stripped table-sm mt-4">
        <thead class="thead-light">
            <tr class="text-uppercase">
                <th class="text-center">N°</th>
                <th>Date</th>
                <th class="">Eleve</th>
                <th class="text-center">Classe</th>
                <th class="text-right">Type</th>
                <th class="text-right">Montant</th>
                <th class="text-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inscriptions as $index => $inscription)
                <tr>
                    <td class="text-center">{{$index+1}}</td>
                    <td class="text-primary" >
                        <a wire:click.prevent="edit({{$inscription}})" href=""data-toggle="modal"
                            data-target="#editPaiementDateModal">
                            {{$inscription->created_at->format('d/m/Y')}}
                        </a>
                    </td>
                    <td>{{$inscription->student->name}}</td>
                    <td class="text-center">{{$inscription->student->classe->name.'/'.$inscription->student->classe->option->name}}</td>
                    <td class="text-right">{{$inscription->cost->name}}</td>
                    <td class="text-right">
                        @if ($inscription->is_paied==false)
                            <span class="text-danger">Non validé</span>
                        @else
                            {{number_format($inscription->cost->amount*$taux,1,',',' ')}}
                        @endif

                    </td>
                    @if (Auth::user()->roles->pluck('name')->contains('Admin'))
                        <td class="text-right">
                            @if ($inscription->is_paied==false)
                                <a
                                    target="_blanck"
                                    href="{{ route('recu.inscription.print',$inscription->id ) }}"> valider
                                </a>
                            @else
                                <a
                                    class="text-info"
                                    target="_blanck"
                                    href="{{ route('recu.inscription.print',$inscription->id ) }}">Ok Réimprimer
                                </a>
                            @endif
                            <button wire:click.prevnet='testPrint({{$inscription}})' class="btn btn-sm btn-info" type="button">&#x1F5A8;</button>
                        </td>
                    @else
                        <td class="text-right">
                            @if ($inscription->is_paied==false)
                                <span class="text-danger">En cours</span>
                            @else
                            <a
                            class="text-info"
                            target="_blanck"
                            href="{{ route('recu.inscription.print',$inscription->id ) }}">Ok Réimprimer</a>

                            @endif

                            <button wire:click.prevnet='testPrint({{$inscription}})' class="btn btn-sm btn-info" type="button">&#x1F5A8;</button>
                        </td>
                    @endif

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
            <h3 class="text-right">Total: {{number_format($total*$taux,1,',',' ')}} Fc</h3>
        </div>
    </div>
    @include('livewire.paiment.modals.edit-paiment-date')
</div>
