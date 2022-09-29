  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="showInRegularisationModal" tabindex="-1" role="dialog" aria-labelledby="showInRegularisationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="showInRegularisationModalLabel"> DETAIL SUR LA REGULARISATION</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="card">
            @if ($inscriptionRegularistionShow)
                <div class="card-body">
                    <h5>Montant: {{$inscriptionRegularistionShow->cost->amount*2000}} Fc</h5>
                    <h5>Type: {{$inscriptionRegularistionShow->cost->name}} Fc</h5>
                    <h5>Régularisation: {{$inscriptionRegularistionShow->regularisation->amount}} Fc</h5>
                    <h5>Reste: {{$inscriptionRegularistionShow->cost->amount*2000-$inscriptionRegularistionShow->regularisation->amount}} Fc</h5>
                </div>
            @endif

        </div>
      </div>
    </div>
  </div>
