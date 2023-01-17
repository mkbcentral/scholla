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
                            <div class="form-group mr-2">
                                <x-label value="{{ __('Type des frais') }}" />
                                <x-select wire:model='type_id'>
                                    <option value="">Choisir...</option>
                                    @foreach ($typeFrais as $type)
                                        <option value="{{$type->id}}">{{$type->name}}</option>
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
                        @php
                            $month='';
                        @endphp
                        <div>
                            <div><h4 class="text-uppercase text-bold text-danger">Liste des élèves qui ne sont pas en ordre</h4></div>
                        </div>
                        <div class="d-flex justify-content-end ">
                            <span class="mr-4"><h3>Total: {{$inscriptions->count()}}</h3></span>
                            <a target="_blank" href="{{ route('control.all.paiment', [$classe_id,$defaultScolaryYer->id,$type_id]) }}" class="btn btn-info btn-sm">Imprimer</a>
                        </div>
                        <table class="table table-stripped table-sm mt-4">
                            <thead class="thead-light">
                                <tr class="text-uppercase">
                                    <th>N°</th>
                                    <th>Date insc.</th>
                                    <th>Noms élèves</th>
                                    @for ($i = 12; $i >=1; $i--)
                                        @php
                                           if ($i<10) {
                                            $month="0".$i;
                                           }else {
                                            $month=$i;
                                           }
                                        @endphp
                                        <th>{{$month}}</th>
                                    @endfor
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
                                        @for ($i = 12; $i >=1 ; $i--)
                                            @php
                                                if ($i<10) {
                                                    $month="0".$i;
                                                }else {
                                                    $month=$i;
                                                }
                                            @endphp
                                             <td>
                                                {{
                                                    $inscription->student->getPaimentByMont(
                                                        $inscription->student->id,
                                                        $month,
                                                        $type_id
                                                    )
                                                }}
                                            </td>
                                        @endfor
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ $index+1}}</td>
                                        <td>{{$inscription->created_at->format('d/m/Y')}}</td>
                                        <td>{{$inscription->student->name}}</td>
                                        @for ($i = 12; $i >=1; $i--)
                                            @php
                                                if ($i<10) {
                                                    $month="0".$i;
                                                }else {
                                                    $month=$i;
                                                }
                                            @endphp
                                         <td>
                                            {{
                                                $inscription->student->getPaimentByMont(
                                                    $inscription->student->id,
                                                    $month,
                                                    $type_id
                                                )
                                            }}
                                        </td>
                                        @endfor
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
