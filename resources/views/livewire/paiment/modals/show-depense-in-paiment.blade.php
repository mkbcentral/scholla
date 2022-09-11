  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="showInDepensePaimentModal" tabindex="-1" role="dialog" aria-labelledby="showInDepensePaimentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="showInDepensePaimentModalLabel"> DETAIL SUR LA DEPENSE</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="card">
            @if ($paiementDepanseShow)
                <div class="card-body">
                    <h5>Montant: {{$paiementDepanseShow->cost->amount*2000}} Fc</h5>
                    <h5>Type: {{$paiementDepanseShow->cost->name}} Fc</h5>
                    <h5>Dépense: {{$paiementDepanseShow->depense->amount}} Fc</h5>
                    <h5>Reste: {{$paiementDepanseShow->cost->amount*2000-$paiementDepanseShow->depense->amount}} Fc</h5>
                </div>
            @endif

        </div>
      </div>
    </div>
  </div>
