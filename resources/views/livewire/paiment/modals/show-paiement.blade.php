  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="showPaiementModal"
  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="showPaiementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="showPaiementModalLabel">PASSER PAIEMENT AUTRES FRAIS</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="p-2">
            @if ($paiments==[])
                <h3 class="text-success text-center p-4">Aucun paiement pour aujourd'hui !</h3>
            @else
                @php
                    $total=0;
                @endphp
                <table class="table table-sm table-light">
                    <thead class="thead-light">
                        <tr>
                            <th>N°</th>
                            <th>DATE</th>
                            <th>CODE</th>
                            <th>ELEVE</th>
                            <th>TYPE</th>
                            <th>MONTANT</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paiments as $index=> $paiment)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$paiment->created_at->format('d/m/Y')}}</td>
                                <td>{{$paiment->number_paiement}}</td>
                                <td>{{$paiment->student->name.'/'.$paiment->student->classe->name.'/'.$paiment->student->classe->option->name}}</td>
                                <td>{{$paiment->cost->name.'/'.strftime('%B', mktime(0, 0, 0, $paiment->mounth_name)) }}</td>
                                <td>{{number_format($paiment->cost->amount*$taux,1,',',' ') }}</td>
                                <td>
                                    <a target="_blank" href="{{ route('recu.frais.print',$paiment->id) }}" class="btn btn-sm btn-primary">&#x1F5A8;</a>
                                    <button class="btn btn-sm btn-danger" wire:click.prevent='annulerPaiement({{$paiment}})'>
                                        Annuler
                                    </button>
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
        </div>
      </div>
    </div>
  </div>
