<div>
    <div>
        <div class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-10">
                <h1 class="m-0 text-danger " style="text-transform: uppercase">&#x1F4B0; DEPENSES SUR LES PAIMENTS FRAIS DE {{$frais->name}}</h1>
                </div>
            </div>
            </div>
        </div>
        <!-- Main content -->
        @php
             $total=0;
        @endphp
        <section class="content">
            <div class="container-fluid">
                <div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-start align-items-center mr-4">
                            <div class="form-group pr-4">
                                <x-label value="{{ __('Filtrer par mois') }}" />
                                <x-select wire:model='month'>
                                    @foreach ($months as $m)
                                        <option value="{{$m}}">{{strftime('%B', mktime(0, 0, 0, $m))}}</option>
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
                        <div>
                            @if ($isDaySorted==true)
                                <a  target="_blank"
                                    class="btn btn-info" href="{{ route('print.depenses.in.paiments.day',
                                    [$type,$date_to_search]) }}">
                                    &#x1F5A8; Imprimer
                                </a>
                            @else
                                <a  target="_blank"
                                    class="btn btn-secondary" href="{{ route('print.depenses.in.paiments.month',
                                    [$type,$month]) }}">
                                    &#x1F5A8; Imprimer
                                </a>
                            @endif
                        </div>
                    </div>

                </div>
                @if ($paiments->isEmpty())
                <h4 class="text-success text-center p-4">Aucun paiment trouvé pour aujourd'hui !</h4>
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
                                <td class="text-right">
                                    @if ($paiment->depense)
                                    {{number_format($paiment->depense->amount,1,',',' ') }}
                                    @else
                                    {{number_format($paiment->cost->amount*$taux,1,',',' ') }}
                                    @endif

                                </td>
                                <td class="text-center">
                                    <span>Ok !</span>
                                </td>

                            </tr>
                            @php
                            if ($paiment->depense) {
                                $total+=$paiment->depense->amount;
                            } else {
                                $total+=$paiment->cost->amount*$taux;
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
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
</div>

