  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="showDetailsPaiements" tabindex="-1" role="dialog" aria-labelledby="showDetailsPaiementsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="showDetailsPaiementsLabel"> DETAIL SUR LA REGULARISATION</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="card">
            @if ($studentPaiements==[])

            @else
                <div>
                    <div class="card">
                        <div class="card-body">
                            <div><span class="text-bold">Nom: </span>{{$inscriptionToShow->student->name}}</div>
                            <div><span class="text-bold">Classe: </span>{{$inscriptionToShow->student->classe->name}}/{{$inscriptionToShow->student->classe->option->name}}</div>
                            <div> <span class="text-bold">Date Insc.: </span>{{$inscriptionToShow->created_at->format('d/m/Y')}}</div>
                        </div>
                    </div>
                </div>
                <table class="table table-light">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>DATE</th>
                            <th>TYPE FRAIS</th>
                            <th>MOIS</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($studentPaiements as $index => $paiement)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$paiement->created_at->format('d/m/Y')}}</td>
                                <td>{{$paiement->cost->name}}</td>
                                <td>{{$paiement->mounth_name}}</td>
                            </tr>
                       @endforeach
                    </tbody>
                </table>
            @endif
        </div>
      </div>
    </div>
  </div>
