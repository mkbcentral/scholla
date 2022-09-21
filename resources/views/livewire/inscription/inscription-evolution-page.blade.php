<div>
    <x-loading-indicator />
    @php
        $total=0;
    @endphp
    <div class="card">
        <div class="card-body">
            <div class="">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>&#x1F4CA; Rapport des inscription</h4>
                    </div>

                </div>
            </div>
            <div class="row mt-4">
                @foreach ($sections as $section)
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box
                                {{$section->name=='Primaire'?'bg-primary':''}}
                                {{$section->name=='Secondaire'?'bg-warning':''}}
                                {{$section->name=='Maternelle'?'bg-success':''}}
                                ">
                            <div class="inner">
                                <h3>{{$section->getInscriptionCount($section->id)}}</h3>
                                <p>{{$section->name}}</p>
                            </div>
                            <a wire:click.prevent='changeIndex({{ $section->id}})'
                                style="cursor: pointer"
                                class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    @php
                        $total+=$section->getInscriptionCount($section->id);
                    @endphp
                @endforeach
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box">
                        <div class="inner text-center">
                            <h2 style="font-size: 35px">{{$total}}</h2>
                            <p style="font-size: 18px">Total</p>
                        </div>
                    </div>
                    <a
                        style="cursor: pointer"
                        class="small-box-footer">-</a>
                </div>
            </div>
            <div class="mt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div><h3>Detail rapport</h3></div>
                    <div>
                        <div class="w-100">
                            <div class="card-tools w-100 ml-2">
                                <div class="input-group input-group-sm">
                                  <input wire:model='keySearch' type="text" class="form-control" placeholder="Recheche ici...">
                                  <div class="input-group-append">
                                    <div class="btn btn-primary">
                                      <i class="fas fa-search"></i>
                                    </div>
                                  </div>
                                </div>
                              </div>
                        </div>
                    </div>
                    <div>
                        <a  class="mt-4 btn btn-secondary" target="_blank" href="{{ route('print.student.section',$selectedIndex) }}">
                            &#x1F5A8;
                            Imprimer les détails
                        </a>
                    </div>
                </div>
                @if ($classes==[])
                    <div class="text-center">
                        <h4 class="text-success">Veillez choisir une section svp !</h4>
                    </div>
                @else
                    <table class="table table-light mt-4">
                        <thead class="thead-light">
                            <tr>
                                <th>Classe</th>
                                <th class="text-center">Nombre élève</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classes as $classe)
                                <tr>
                                    <td>{{$classe->name.'/'.$classe->option->name}}</td>
                                    <td class="text-center">{{$classe->students->count()}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
