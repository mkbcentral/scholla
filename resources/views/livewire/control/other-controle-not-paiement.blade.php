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
                  <div class="tab-content">
                    <div class="active tab-pane" id="inscription">
                        <div class="form-group">
                            <label for="my-select">Anné scolaire</label>
                          <div class="input-group date"  >
                            <select id="my-select" class="form-control" wire:model.defer='scolary_id'>
                                <option >Choisir...</option>
                                @foreach ($scolaryyears as $year)
                                    <option wire:click.prevent='changeScolaryid' value="{{$year->id}}">{{$year->name}}</option>
                                @endforeach
                            </select>
                              <div class="input-group-append" >
                                    <button wire:click='changeScolaryid' class="btn btn-info" type="button"><i class="fa fa-search"></i></button>
                              </div>
                          </div>
                      </div>
                       <div class="d-flex justify-content-between align-items-center">
                           <div class="d-flex justify-content-start align-items-center">
                            <div class="form-group">
                                <x-label value="{{ __('Filtrer par par classe') }}" />
                                <x-select wire:model='classe_id'>
                                    <option value="">Choisir...</option>
                                    @foreach ($classes as $classe)
                                        <option value="{{$classe->id}}">{{$classe->name.'/'.$classe->option->name}}</option>
                                    @endforeach
                                </x-select>
                            </div>
                            <div class="form-group pr-4">
                                <x-label value="{{ __('Filtrer par type frais') }}" />
                                <x-select wire:model='cost_id'>
                                    <option value="0">Choisir...</option>
                                    @foreach ($costs as $cost)
                                        <option value="{{$cost->id}}">{{$cost->name}}</option>
                                    @endforeach
                                </x-select>
                            </div>
                            <div class="form-group pr-4">
                                <x-label value="{{ __('Filtrer par tranche') }}" />
                                <x-select wire:model='tranche_id'>
                                    <option value="0">Choisir...</option>
                                    @foreach ($tranches as $tranche)
                                        <option value="{{$tranche->id}}">{{$tranche->name}}</option>
                                    @endforeach
                                </x-select>
                            </div>
                           </div>
                       </div>
                       <div>
                        @if ($inscriptions->isEmpty())
                            <span class="text-success text-center p-4">
                                <h4><i class="fa fa-database" aria-hidden="true"></i>
                                         Selection une classe SVP !
                                </h4>
                            </span>
                        @else
                        <div>
                            <div><h4 class="text-uppercase text-bold text-danger">Liste des élèves qui ne sont pas en ordre</h4></div>
                        </div>
                        <div class="d-flex justify-content-end ">
                            <span class="mr-4"><h3>Total: {{$inscriptions->count()}}</h3></span>
                            <a target="_blank" href="{{ route('not.other.paiment',
                                [ $classe_id,$tranche_id,$this->defaultScolaryYer->id]) }}" class="btn btn-info btn-sm">Imprimer</a>
                        </div>
                        <table class="table table-stripped table-sm mt-4">
                            <thead class="thead-light">
                                <tr class="text-uppercase">
                                    <th>N°</th>
                                    <th>Date insc.</th>
                                    <th>Noms élèves</th>
                                    <th>Classe</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inscriptions as $index=> $inscription)
                                @if (in_array($inscription->created_at->format('d'), $days) &&
                                    $inscription->created_at->format('m')== $month)
                                    <tr class="bg-secondary">
                                        <td>{{ $index+1}}</td>
                                        <td>{{$inscription->created_at->format('d/m/Y')}}</td>
                                        <td>{{$inscription->student->name}}</td>
                                        <td>{{$inscription->student->classe->name.'/'.$inscription->student->classe->option->name}}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ $index+1}}</td>
                                        <td>{{$inscription->created_at->format('d/m/Y')}}</td>
                                        <td>{{$inscription->student->name}}</td>
                                        <td>{{$inscription->student->classe->name.'/'.$inscription->student->classe->option->name}}</td>
                                    </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                        @endif
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
