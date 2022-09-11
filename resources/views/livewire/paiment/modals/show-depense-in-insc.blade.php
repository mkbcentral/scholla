  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="showInDepenseModal" tabindex="-1" role="dialog" aria-labelledby="showInDepenseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="showInDepenseModalLabel"> DETAIL SUR LA DEPENSE</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="card">
            @if ($inscriptionDepenseShow)
                <div class="card-body">
                    <h5>Montant: {{$inscriptionDepenseShow->cost->amount*2000}} Fc</h5>
                    <h5>Type: {{$inscriptionDepenseShow->cost->name}} Fc</h5>
                    <h5>Dépense: {{$inscriptionDepenseShow->depense->amount}} Fc</h5>
                    <h5>Reste: {{$inscriptionDepenseShow->cost->amount*2000-$inscriptionDepenseShow->depense->amount}} Fc</h5>
                </div>
            @endif

        </div>
      </div>
    </div>
  </div>
