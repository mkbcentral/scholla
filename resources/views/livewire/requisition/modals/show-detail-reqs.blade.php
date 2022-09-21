  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="formShowDetailModal" tabindex="-1" role="dialog" aria-labelledby="formShowDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formShowDetailModalLabel">AJOUTER UN DETAIL</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @php
            $total=0;
        @endphp
        <div class="modal-body">
           @if ($details==[])
                <h5 class="text-center">Aucun détail trouvé !</h5>
           @else
            <table class="table table-light table-sm">
                <thead class="thead-light">
                    <tr>
                        <th>N°</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $index => $detail)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$detail->description}}</td>
                            <td>{{$detail->amount}}</td>
                            <td>
                                @if ($detail->active==false)
                                    Non validé
                                @else
                                    <span class="text-success">Validé</span>
                                @endif
                            </td>
                            <td>
                                <x-button wire:click.prevent='activeDetal({{$detail}},{{$requisitiionToShow}})'
                                    class=" {{$detail->active==false?'text-info':'text-dager'}}">
                                    <i class="fa {{$detail->active==false?'fa-check':'fa-times'}}" aria-hidden="true"></i>
                                </x-button>

                                <x-button wire:click.prevent='deleteDetail({{$detail}},{{$requisitiionToShow}})'
                                class="text-danger"><i class="fa fa-trash" aria-hidden="true"></i></x-button>
                            </td>
                        </tr>
                        @php
                            if ($detail->active==true) {
                                $total+=$detail->amount;
                            }
                        @endphp
                    @endforeach
                </tbody>
            </table>
            <div class=" d-flex justify-content-end">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title  text-bold">Total: {{$total}}</h4>
                    </div>
                </div>
            </div>
           @endif
        </div>
      </div>
    </div>
  </div>
