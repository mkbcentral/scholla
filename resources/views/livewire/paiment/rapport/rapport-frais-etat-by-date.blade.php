<div>
    <x-loading-indicator />
    @php
        $total=0;
    @endphp
     <!-- Main content -->
     <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div><h4 class="text-uppercase text-primary">&#x1F5C2; Situation frais de l'états</h4></div>
            </div>
        </div>
    </div>
     <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- /.col -->
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="inscription">
                       <div class="d-flex justify-content-between align-items-center">
                           <div class="d-flex justify-content-start align-items-center">
                            <div class="form-group">
                                <x-label value="{{ __('Filtrer par date') }}" />
                                <x-input class="" type='date'
                                         placeholder="Date" wire:model='date_to_search'/>
                            </div>
                           </div>
                       </div>
                       <div>
                        @if ($paiments->isEmpty())
                            <span class="text-success text-center p-4">
                                <h4><i class="fa fa-database" aria-hidden="true"></i>
                                         Filtre invalide SVP !
                                </h4>
                            </span>
                        @else
                        <div>
                            <div><h4 class="text-uppercase text-bold text-danger">Rapport de paiemnt par date</h4></div>
                        </div>
                        <div class="d-flex justify-content-end ">
                            <span class="mr-4"><h3>Total: {{$paiments->count()}}</h3></span>
                            <a target="_blank" href="{{ route('print.paiement.frais.etat.by.date', $date_to_search) }}" class="btn btn-info btn-sm">Imprimer</a>
                        </div>
                        <table class="table table-stripped table-sm">
                            <thead class="thead-light">
                                <tr class="text-uppercase">
                                    <th>N°</th>
                                    <th>Date paiment.</th>
                                    <th>Noms élèves</th>
                                    <th>tYPE</th>
                                    <th class="text-right">Montant</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paiments as $index => $paiment)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $paiment->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $paiment->student->name.'/'.$paiment->student->classe->name.'/'.$paiment->student->classe->option->name }}</td>
                                        <td>{{ $paiment->cost->name }}</td>
                                        <td class="text-right">{{number_format($paiment->cost->amount * 2000,1,',',' ')}}</td>
                                    </tr>
                                    @php
                                        $total +=($paiment->cost->amount)*2000
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                        <div class="card ">
                            <div class="card-body d-flex justify-content-end ">
                                <h3 class="text-right">Total: {{number_format($total,1,',',' ')}} Fc</h3>
                            </div>
                        </div>
                       </div>
                    </div>
                  </div>
                  <!-- /.tab-content -->
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

</div>
