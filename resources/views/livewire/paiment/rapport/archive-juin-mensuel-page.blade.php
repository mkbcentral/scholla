<div>
    <x-loading-indicator />
    @php
        $total=0;
    @endphp
     <!-- Main content -->
     <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div><h4 class="text-uppercase text-primary">&#x1F5C2;aRCHIVE GLOBAL</h4></div>
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
                            <div class="form-group pr-4">
                                <x-label value="{{ __('Filtrer par mois') }}" />
                                <x-select wire:model='month'>
                                    @foreach ($months as $m)
                                        <option value="{{$m}}">{{strftime('%B', mktime(0, 0, 0, $m,10))}}</option>
                                    @endforeach
                                </x-select>
                            </div>
                            <div class="form-group mr-2">
                                <x-label value="{{ __('Type tranche') }}" />
                                <x-select wire:model='cost_id'>
                                    <option value="">Choisir...</option>
                                    @foreach ($costs as $cost)
                                        <option value="{{$cost->id}}">{{$cost->name}}</option>
                                    @endforeach
                                </x-select>
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
                            <div><h4 class="text-uppercase text-bold text-danger">Rapport</h4></div>
                        </div>
                        <div class="d-flex justify-content-end ">
                            <span class="mr-4"><h4>Total: {{$paiments->count()}}</h4></span>
                            <a target="_blank" href="{{ route('print.paiement.frais.archive.global', [$cost_id,$month]) }}" class="btn btn-info btn-sm"><i class="fa fa-print" aria-hidden="true"></i> Imprimer</a>
                        </div>

                        <table class="table table-stripped table-sm">
                            <thead class="thead-light">
                                <tr class="text-uppercase">
                                    <th>N°</th>
                                    <th>Date paiment.</th>
                                    <th>Noms élèves</th>
                                    <th>Type</th>
                                    <th class="text-right">Montant</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paiments as $index => $paiment)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $paiment->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $paiment->student->name }}</td>
                                        <td>{{ $paiment->cost->name }}</td>
                                        @if ($cost_id==0)
                                            @php
                                                $amount=0;
                                                if ($paiment->cost->id==38) {
                                                    //dd($paiment->cost->name)8000;
                                                    $amount=($paiment->cost->amount*2000)-40000;

                                                } elseif($paiment->cost->id==37) {
                                                    //$amount=10000;
                                                    $amount=($paiment->cost->amount*2000)-50000;
                                                }elseif($paiment->cost->id==39) {
                                                    //$amount=10000;
                                                    $amount=($paiment->cost->amount*2000)-50000;
                                                }elseif($paiment->cost->id==40) {
                                                    //$amount=12000;
                                                    $amount=($paiment->cost->amount*2000)-60000;
                                                }elseif($paiment->cost->id==41) {
                                                    $amount=($paiment->cost->amount*2000)-80000;
                                                }elseif($paiment->cost->id==42) {
                                                    //$amount=18000;
                                                    $amount=($paiment->cost->amount*2000)-90000;
                                                }
                                                $total +=$amount;
                                            @endphp
                                            <td class="text-right">{{number_format($amount,1,',',' ')}}</td>
                                        @else
                                            <td class="text-right">{{number_format($paiment->getArchiveAmount($cost_id),1,',',' ')}}</td>
                                            @php
                                                $total +=($paiment->getArchiveAmount($cost_id))
                                            @endphp
                                        @endif

                                    </tr>
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
