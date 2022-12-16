<div>
    <x-loading-indicator />

     <!-- Main content -->
     <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- /.col -->
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                    <div>
                        <div  class="d-flex justify-content-between">
                            <div><h4 class="text-uppercase text-bold text-danger">Liste des élèves</h4></div>
                            <div class="mr-4">
                                <x-button
                                    wire:click.prevent='getGetPaiementDay'
                                    type="button"
                                    class="btn btn-info"
                                    data-toggle="modal"
                                    data-target="#showPaiementModal">
                                    Voire le paiment journalier
                                </x-button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            <div class="w-25">
                                <div class="card-tools">
                                    <div class="input-group input-group-sm">
                                    <input wire:model.debounce.500ms='keySearch' type="text" class="form-control" placeholder="Recheche ici...">
                                    <div class="input-group-append">
                                        <div class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($inscriptions->isEmpty())
                        <span class="text-success text-center p-4">
                            <h4><i class="fa fa-database" aria-hidden="true"></i>
                                Elève non trouvé ! Veuillez refaire la recherche SVP !
                            </h4>
                        </span>
                        @else
                            <table class="table table-stripped table-sm mt-4">
                                <thead class="thead-light">
                                    <tr class="text-uppercase">
                                        <th>N°</th>
                                        <th>Noms élèves</th>
                                        <th>Classe</th>
                                        <th class="text-center">Genre</th>
                                        <th class="text-center">Age</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inscriptions as $index=> $inscription)
                                        <tr class="{{$inscription->is_bascule==true?'bg-danger':''}}">
                                            <td>{{ $index+1}}</td>
                                            <td>{{$inscription->student->name}}</td>
                                            <td>
                                                {{$inscription->student->classe->name.'/'.$inscription->student->classe->option->name}}
                                                {{$inscription->is_bascule==true?'| Ancienne classe de bascule':''}}
                                            </td>
                                            <td class="text-center">{{$inscription->student->gender}}</td>
                                            <td class="text-center">
                                                @if (date('Y')-$inscription->student->date_of_birth->format('Y')==0)
                                                    <span class="text-danger">Inconu</span>
                                                @elseif(date('Y')-$inscription->student->date_of_birth->format('Y')==1)
                                                    {{date('Y')-$inscription->student->date_of_birth->format('Y')}} An
                                                @else
                                                    {{date('Y')-$inscription->student->date_of_birth->format('Y')}} Ans
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button wire:click.prevent='show({{$inscription}})'
                                                            class="btn btn-sm btn-info" type="button"
                                                        data-toggle="modal"
                                                        data-target="#formPaiementListingModal">
                                                    Passer paiment
                                                </button>
                                                <button wire:click.prevent='getPaiements({{$inscription->student->id}},{{$inscription->id}})'
                                                            class="btn btn-sm btn-primary" type="button"
                                                        data-toggle="modal"
                                                        data-target="#showDetailsPaiements">
                                                   Voir détails
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                   </div>
                </div><!-- /.card-body -->
              </div>

              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
      <!-- /.content -->

    @include('livewire.paiment.modals.paiement-form-listing')
    @include('livewire.paiment.modals.show-paiement')
    @include('livewire.paiment.modals.show-detail-paiement')
</div>
